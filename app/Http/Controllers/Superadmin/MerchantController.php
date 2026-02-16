<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Jobs\SendPluginUpdateEmailJob;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\LicenseActivation;
use App\Models\License;
use App\Models\PluginUpdateNotice;
use App\Models\PluginVersion;
use App\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class MerchantController extends Controller
{
    public function index()
    {
        $users = User::where('role', 0)
            ->with(['license.activations'])
            ->paginate();

        return view('superadmin.merchant.index', compact('users'));
    }


    public function subscribe_store_index(Request $request)
    {
        $query = License::with(['user', 'activations', 'planInfo']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('store_name', 'like', "%$search%");
            })->orWhereHas('activations', function ($q) use ($search) {
                $q->where('store_url', 'like', "%$search%");
            });
        }

        $allSubscribes = (clone $query)->get();

        $totalStores   = $allSubscribes->count();
        $activeStores  = $allSubscribes->where('status', 'active')->count();
        $paidPlans     = $allSubscribes->whereIn('status', ['expired', 'revoked'])->count();

        $totalAmount = $allSubscribes->sum(function ($item) {
            return optional($item->planInfo)->price ?? 0;
        });

        $subscribes = $query->paginate();

        return view('superadmin.merchant.subscribe_store_index', compact(
            'subscribes',
            'totalStores',
            'activeStores',
            'paidPlans',
            'totalAmount'
        ));
    }


    public function license_managment_index(Request $request)
    {
        $query = License::with('user');

        // Search by license key
        if ($request->filled('search_license_key')) {
            $query->where('license_key', 'like', '%' . $request->search_license_key . '%');
        }

        // Search by assigned store name
        if ($request->filled('search_store_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('store_name', 'like', '%' . $request->search_store_name . '%');
            });
        }

        // Search by status
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }


        $licenses = $query->get();
        $licensesPerPage = $query
            ->orderBy('created_at', 'desc')
            ->paginate();

        // Pass everything to the view
        return view('superadmin.merchant.license_managment_index', compact(
            'licenses',
            'licensesPerPage'
        ));
    }




    public function global_stats_index()
    {
        return view('superadmin.merchant.global_star');
    }



    // public function store_earning_index()
    // {

    //     return view('superadmin.merchant.store_earning_index');
    // }


    public function logs_error_index()
    {

        return view('superadmin.merchant.logs_error_index');
    }




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

        // ✅ Check if zip_path exists first
        if (!empty($plugin->zip_path)) {

            if (Storage::exists($plugin->zip_path)) {
                Storage::delete($plugin->zip_path);
            }
        }

        // Delete record anyway
        $plugin->delete();

        return redirect()->back()->with('success', 'Plugin deleted successfully!');
    }


    //end plugin actions


    public function support_index()
    {

        return view('superadmin.merchant.support_index');
    }


    public function viewStores($licenseId)
    {
        $license = License::with(['user', 'planInfo'])->findOrFail($licenseId);

        $activations = LicenseActivation::where('license_id', $license->id)
            ->orderBy('activated_at', 'desc')
            ->paginate(10);

        return view('superadmin.merchant.view_stores', compact(
            'license',
            'activations'
        ));
    }
}
