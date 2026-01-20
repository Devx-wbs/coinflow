<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class GlobalSettingApiController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all settings
        $settings = GlobalSetting::select('key', 'value')->get();

        // Convert JSON values back to array if needed
        $formatted = $settings->mapWithKeys(function ($item) {
            $value = json_decode($item->value, true);
            return [$item->key => $value ?? $item->value];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }
}
