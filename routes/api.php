<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\PluginUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\Api\GlobalSettingApiController;
use App\Http\Controllers\Api\OrderController;
use App\Models\User;




    Route::post('/stores/register', [StoreController::class, 'register']);
    
    
    // Registration (no token)
    Route::post('/register', function(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user
        ]);
    });
    
    // Login (token generated here)
    Route::post('/login', function(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('api-token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ]);
    });

    
    // Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    //     return response()->json($request->user());
    // });
    
      // Free plan registration - public
  

    Route::middleware('auth:sanctum')->group(function () {
         #verify license
        //plugin user
        Route::get('/plugin-users', [PluginUserController::class, 'index']);        // Get all
        Route::post('/plugin-users', [PluginUserController::class, 'store']);       // Create
        Route::get('/plugin-users/{id}', [PluginUserController::class, 'show']);    // Get single
        Route::put('/plugin-users/{id}', [PluginUserController::class, 'update']);  // Update
        Route::delete('/plugin-users/{id}', [PluginUserController::class, 'destroy']); // Delete
    });

    Route::post('/verify-deactivation-license', [LicenseController::class, 'deactivateStore']);




    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello from API!']);
    });
    Route::post('/license/validate', [LicenseController::class, 'validateLicense']);
    
    Route::post('/license/create', [LicenseController::class, 'createLicense']);
    
    Route::get('/global-settings', [GlobalSettingApiController::class, 'index']);
    Route::post('/verify-activation-license', [LicenseController::class, 'verify']);
    
    
    
    Route::post('/orders', [OrderController::class, 'store']);




