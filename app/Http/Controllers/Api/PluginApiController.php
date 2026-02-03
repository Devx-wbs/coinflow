<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PluginVersion;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PluginApiController extends Controller
{
    /**
     * Latest Plugin Version
     */
    public function latest(Request $request)
    {
        $licenseKey = $request->query('license_key');

        $license = $this->validateLicense($licenseKey);
        if (!$license) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or inactive License'
            ], 401);
        }

        $latest = PluginVersion::orderBy('released_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();


        if (!$latest) {
            return response()->json([
                'status' => false,
                'message' => 'No plugin versions available'
            ], 404);
        }

        $installedVersion = $request->query('current_version');
        $updateRequired = $installedVersion
            ? version_compare($installedVersion, $latest->version, '<')
            : false;

        return response()->json([
            'status' => true,
            'latest_version' => $latest->version,
            'released_at' => $latest->released_at->format('Y-m-d'),
            'download_url' => route('plugin.download', $latest->id)
                . "?license_key={$licenseKey}",
            'update_required' => $updateRequired,
            'message' => $updateRequired ? 'New update available' : 'You are using the latest version'
        ]);
    }

    /**
     * List All Versions
     */
    public function index(Request $request)
    {
        $licenseKey = $request->query('license_key');
        $license = $this->validateLicense($licenseKey);
        if (!$license) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or inactive License'
            ], 401);
        }

        $versions = PluginVersion::orderBy('released_at', 'desc')->get();

        $versions->transform(function ($version) use ($licenseKey) {
            $version->download_url = route('plugin.download', $version->id)
                . "?license_key={$licenseKey}";
            return $version;
        });

        return response()->json([
            'status' => true,
            'data' => $versions
        ]);
    }

    /**
     * View Single Version
     */
    public function view(Request $request, $id)
    {
        $licenseKey = $request->query('license_key');

        $license = $this->validateLicense($licenseKey);
        if (!$license) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or inactive License'
            ], 401);
        }

        $plugin = PluginVersion::find($id);

        if (!$plugin) {
            return response()->json([
                'status' => false,
                'message' => 'Plugin not found'
            ], 404);
        }

        $plugin->download_url = route('plugin.download', $plugin->id)
            . "?license_key={$licenseKey}";

        return response()->json([
            'status' => true,
            'data' => $plugin
        ]);
    }

    /**
     * Download Plugin
     */
    public function download(Request $request, $id)
    {

        $licenseKey = $request->query('license_key');

        $license = $this->validateLicense($licenseKey);

        if (!$license) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or inactive License'
            ], 401);
        }

        $plugin = PluginVersion::find($id);

        if (!$plugin || !Storage::exists($plugin->zip_path)) {
            return response()->json([
                'status' => false,
                'message' => 'Plugin not found'
            ], 404);
        }

        return Storage::download($plugin->zip_path, "coinflow-{$plugin->version}.zip");
    }

    /**
     * Helper: Validate License
     */
    protected function validateLicense($licenseKey)
    {
        return License::where('license_key', $licenseKey)
            ->where('status', 'active') // only active licenses
            ->first();
    }
}
