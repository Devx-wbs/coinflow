<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\License;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\LicenseActivation;

class LicenseController extends Controller
{
    public function validateLicense(Request $request)
    {
        $license = License::where('license_key', $request->license_key)
            ->where('store_url', $request->store_url)
            ->first();

        if ($license && $license->status === 'active') {
            return response()->json([
                'valid' => true,
                'plan' => $license->plan,
                'expires_at' => $license->expiration_date,
            ]);
        }

        return response()->json(['valid' => false], 401);
    }

    public function createLicense(Request $request)
    {
        $licenseKey = strtoupper(bin2hex(random_bytes(8))); // random 16-char key

        $license = License::create([
            'license_key' => $licenseKey,
            'store_url'   => $request->store_url,
            'status'      => 'active',
            'plan'        => $request->plan ?? 'free',
            'expiration_date' => $request->expiration_date ?? now()->addYear(),
        ]);

        return response()->json([
            'message' => 'License created successfully',
            'data' => $license
        ]);
    }

    #Activation licence logic
    public function verify(Request $request)
    {
        $license = License::where('license_key', $request->license_key)->first();

        if (!$license) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid license'
            ]);
        }

        if ($license->expiration_date && now()->gt($license->expiration_date)) {
            return response()->json([
                'success' => false,
                'message' => 'License expired',
                'expiration_date' => $license->expiration_date
            ]);
        }

        // Find activation (active or inactive)
        $activation = LicenseActivation::where('license_id', $license->id)
            ->where('store_url', $request->store_url)
            ->first();

        // Count active stores ONCE
        $activeCount = LicenseActivation::where('license_id', $license->id)
            ->where('status', 'active')
            ->count();

        /** -------------------------------
         * CASE 1: Activation exists
         * -------------------------------*/
        if ($activation) {

            // Already active → NO CHANGE
            if ($activation->status === 'active') {
                return response()->json([
                    'success' => true,
                    'message' => 'Store already active',
                    'total_activations' => $license->max_activations,
                    'used_activations' => $activeCount,
                    'remaining_activations' => $license->max_activations - $activeCount,
                    'expiration_date' => $license->expiration_date
                ]);
            }

            // Inactive → Active
            if ($license->max_activations > 0 && $activeCount >= $license->max_activations) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum activation limit reached'
                ]);
            }

            $activation->deactivated_at = null;
            $activation->status = 'active';
            $activation->activated_at = Carbon::now();
            $activation->save();

            $activeCount++; // ✅ correct increment
        }

        /** -------------------------------
         * CASE 2: New activation
         * -------------------------------*/
        else {
            if ($license->max_activations > 0 && $activeCount >= $license->max_activations) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum activation limit reached'
                ]);
            }

            LicenseActivation::create([
                'license_id'   => $license->id,
                'store_url'    => $request->store_url,
                'status'       => 'active',
                'activated_at' => now(),
            ]);

            $activeCount++; // ✅ correct increment
        }

        return response()->json([
            'success' => true,
            'message' => 'Store activated successfully',
            'total_activations' => $license->max_activations,
            'used_activations' => $activeCount,
            'remaining_activations' => $license->max_activations == 0 ? 'Unlimited' : max(0, $license->max_activations - $activeCount),
            'expiration_date' => $license->expiration_date
        ]);
    }

    #Deactivation licence logic
    public function deactivateStore(Request $request)
    {
        $license = License::where('license_key', $request->license_key)->first();

        if (!$license) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid license'
            ]);
        }

        $activation = LicenseActivation::where('license_id', $license->id)
            ->where('store_url', $request->store_url)
            ->first();

        if (!$activation) {
            return response()->json([
                'success' => false,
                'message' => 'Store activation not found'
            ]);
        }

        // Already inactive → no change
        if ($activation->status === 'inactive') {
            $activeCount = LicenseActivation::where('license_id', $license->id)
                ->where('status', 'active')
                ->count();

            return response()->json([
                'success' => true,
                'message' => 'Store already inactive',
                'total_activations' => $license->max_activations,
                'used_activations' => $activeCount,
                'remaining_activations' => $license->max_activations - $activeCount,
                'expiration_date' => $license->expiration_date
            ]);
        }

        /**
         * Deactivate store
         */

        $activation->deactivated_at = Carbon::now();
        $activation->status = 'inactive';
        $activation->save();

        // Active count AFTER deactivation
        $activeCount = LicenseActivation::where('license_id', $license->id)
            ->where('status', 'active')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Store deactivated successfully',
            'total_activations' => $license->max_activations,
            'used_activations' => $activeCount,
            'remaining_activations' => $license->max_activations == 0 ? 'Unlimited' : max(0, $license->max_activations - $activeCount),
            'expiration_date' => $license->expiration_date
        ]);
    }
}
