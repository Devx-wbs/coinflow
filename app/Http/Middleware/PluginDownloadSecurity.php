<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\License;

class PluginDownloadSecurity
{
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Allow Admin / Support / Sub Admin Without License Key
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {

            $user = auth()->user();

            // Spatie Role Check
            if ($user->hasRole(['admin', 'sub_admin', 'support'])) {
                return $next($request);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Guest or Normal User → License Key Required
        |--------------------------------------------------------------------------
        */

        $licenseKey = $request->query('license_key');

        if (!$licenseKey) {
            return response()->json([
                'success' => false,
                'message' => 'License key is required to download this plugin.'
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Validate License Key
        |--------------------------------------------------------------------------
        */

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid license key.'
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Check License Status (Optional but Recommended)
        |--------------------------------------------------------------------------
        */

        if ($license->status != 'active') {
            return response()->json([
                'success' => false,
                'message' => 'License is inactive or expired.'
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Attach License to Request (Controller can use it)
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'license' => $license
        ]);

        return $next($request);
    }
}
