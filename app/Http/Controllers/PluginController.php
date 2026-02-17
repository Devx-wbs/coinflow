<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendPluginUpdateEmailJob;
use App\Models\LicenseActivation;
use App\Models\PluginUpdateNotice;
use App\Models\PluginVersion;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PluginController extends Controller
{
    public function update_tracker_index()
    {
        // 1️⃣ Get all plugin versions with activation count



        $plugins = PluginVersion::with(['screenshot'])
            ->withCount('activations')
            ->orderBy('released_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();


        // 2️⃣ Find latest plugin version (type_id = Latest)
        $latestVersion = PluginVersion::where('type_id', PluginVersion::TYPE_LATEST)->first();



        // 3️⃣ Total unique stores (store_url distinct)
        $totalStores = LicenseActivation::distinct('store_url')
            ->count('store_url');

        // 4️⃣ Stores using latest version (unique store_url)
        $latestStores = 0;

        if ($latestVersion) {
            $latestStores = LicenseActivation::where('plugin_id', $latestVersion->id)
                ->distinct('store_url')
                ->count('store_url');
        }

        // 5️⃣ Outdated stores = total - latest
        $outdatedStores = $totalStores - $latestStores;

        $storeCounts = LicenseActivation::selectRaw(
            'plugin_id, COUNT(DISTINCT store_url) as total'
        )
            ->groupBy('plugin_id')
            ->pluck('total', 'plugin_id');

        return view(
            'superadmin.merchant.update_tracker_index',
            compact(
                'plugins',
                'totalStores',
                'latestVersion',
                'latestStores',
                'outdatedStores',
                'storeCounts'
            )
        );
    }


    public function add_plugin(Request $request, StorageService $storageService)
    {
        $request->validate([
            'version' => 'required|string|unique:plugin_versions,version',
            'zip' => 'required|file|mimes:zip',
            'released_at' => 'required|date',
            'description' => 'nullable|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Extension
        $extension = $request->file('zip')->getClientOriginalExtension();

        // Custom filename using version
        $fileName = "coinflow_" . $request->version . "." . $extension;

        // Store with custom name
        $zipPath = $request->file('zip')->storeAs(
            'plugins',
            $fileName
        );

        DB::transaction(function () use ($request, $zipPath, $storageService) {

            $newPlugin = PluginVersion::create([
                'version' => $request->version,
                'zip_path' => $zipPath,
                'released_at' => $request->released_at,
                'description' => $request->description,
                'state_id' => PluginVersion::STATE_ACTIVE,
                'type_id' => PluginVersion::TYPE_LATEST,
                'category_id' => $request->category_id
            ]);

            // 🔥 Upload screenshot using your StorageService
            if ($request->hasFile('screenshot')) {
                $storageService->upload(
                    $request->file('screenshot'),
                    $newPlugin,
                    'plugin_screenshots'
                );
            }

            PluginVersion::where('id', '!=', $newPlugin->id)
                ->where('type_id', PluginVersion::TYPE_LATEST)
                ->update([
                    'type_id' => PluginVersion::TYPE_OUTDATED
                ]);
        });


        return redirect()->back()->with('success', 'Plugin uploaded successfully!');
    }


    public function exportPluginReport(Request $request)
    {
        // Load all plugin versions
        $plugins = PluginVersion::orderBy('released_at', 'desc')->get();

        // Total Unique Stores (across all plugins)
        $totalStores = LicenseActivation::distinct('store_url')->count('store_url');

        // CSV Headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="plugin_update_report.csv"',
        ];

        // CSV Columns
        $columns = [
            'Plugin Version',
            'Release Date',
            'Store Count',
            'Percentage (%)',
            'Category',
            'Type',
            'State'
        ];

        // Stream Callback
        $callback = function () use ($plugins, $columns, $totalStores) {

            $file = fopen('php://output', 'w');

            // Add Header Row
            fputcsv($file, $columns);

            foreach ($plugins as $plugin) {

                // Store Count for this plugin version
                $storeCount = LicenseActivation::where('plugin_id', $plugin->id)
                    ->distinct('store_url')
                    ->count('store_url');

                // Percentage
                $percentage = $totalStores > 0
                    ? ($storeCount / $totalStores) * 100
                    : 0;

                // Add Row
                fputcsv($file, [
                    $plugin->version,
                    $plugin->released_at?->format('Y-m-d'),
                    $storeCount,
                    number_format($percentage, 1),

                    // Category Name
                    $plugin->category_name ?? 'N/A',

                    // Type Name
                    $plugin->type_name ?? 'N/A',

                    // State Name
                    $plugin->state_name ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function sendUpdateNotice($pluginVersionId)
    {
        $latestVersion = PluginVersion::findOrFail($pluginVersionId);


        // Find stores NOT using latest version
        $outdatedStores = LicenseActivation::where('plugin_id', '!=', $latestVersion->id)
            ->get();



        foreach ($outdatedStores as $activation) {
            // Prevent duplicate notice
            $notice = PluginUpdateNotice::firstOrCreate(
                [
                    'plugin_version_id' => $latestVersion->id,
                    'license_id'        => $activation->license_id,
                ],
                [
                    'email'     => $activation->license->user->email,
                    'store_url' => $activation->store_url,
                    'status'    => PluginUpdateNotice::STATUS_PENDING,
                ]
            );



            // Dispatch only if still pending
            if ($notice->status == PluginUpdateNotice::STATUS_PENDING) {
                SendPluginUpdateEmailJob::dispatch($notice->id);
            }
        }

        return back()->with('success', 'Update notices queued successfully!');
    }




    public function download($id)
    {
        $plugin = PluginVersion::findOrFail($id);

        // Debug check
        if (!$plugin->zip_path) {
            return redirect()->back()->with('error', 'Zip file path missing in database!');
        }

        if (!Storage::exists($plugin->zip_path)) {
            return redirect()->back()->with('error', 'Zip file not found in storage!');
        }

        return Storage::download($plugin->zip_path);
    }


    /**
     * Delete plugin version
     */


    public function destroy($id)
    {
        $plugin = PluginVersion::findOrFail($id);

        $wasLatest = $plugin->type_id == PluginVersion::TYPE_LATEST;

        // Delete zip file
        if (!empty($plugin->zip_path) && Storage::exists($plugin->zip_path)) {
            Storage::delete($plugin->zip_path);
        }

        $plugin->delete();

        // 🔥 If deleted plugin was Latest → promote newest one
        if ($wasLatest) {

            $newLatest = PluginVersion::orderBy('released_at', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            if ($newLatest) {
                $newLatest->update([
                    'type_id' => PluginVersion::TYPE_LATEST
                ]);
            }
        }

        return back()->with('success', 'Plugin deleted successfully!');
    }


    public function update(Request $request, $id, StorageService $storageService)
    {
        $plugin = PluginVersion::findOrFail($id);

        $request->validate([
            'released_at' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'required',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        DB::transaction(function () use ($request, $plugin, $storageService) {

            // ✅ Update other fields
            // $plugin->version = $request->version;
            $plugin->released_at = $request->released_at;
            $plugin->description = $request->description;
            $plugin->category_id = $request->category_id;
            $plugin->save();

            // ✅ Screenshot replace (if uploaded)
            if ($request->hasFile('screenshot')) {

                // Delete old screenshot if exists
                if ($plugin->screenshot) {
                    $storageService->delete($plugin->screenshot);
                }

                // Upload new screenshot
                $storageService->upload(
                    $request->file('screenshot'),
                    $plugin,
                    'plugin_screenshots'
                );
            }
        });

        return back()->with('success', 'Plugin updated successfully!');
    }
}
