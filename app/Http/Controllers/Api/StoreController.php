<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Plan;

class StoreController extends Controller
{
    public function plugin_register(Request $request)
    {
        $request->validate([
            'store_url' => 'required|url',
            'plugin_version' => 'required|string'
        ]);

        $plan = Plan::where('name', 'Free')->first();

        $store = Store::updateOrCreate(
            ['store_url' => $request->store_url],
            [
                'plan_id' => $plan->id,
                'plugin_version' => $request->plugin_version,
                'status' => 'active',
                'last_seen' => now()
            ]
        );

        return response()->json([
            'status' => 'registered',
            'store_id' => $store->id,
            'plan' => 'free'
        ]);
    }
    
    
}
