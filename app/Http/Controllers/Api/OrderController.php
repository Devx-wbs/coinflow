<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Store;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders',
            'store_id' => 'required|integer',
            'amount' => 'required|numeric',
            'fee' => 'nullable|numeric',
            'status' => 'required|string',
            'origin' => 'nullable|string',
            'paid_at' => 'nullable|date',
        ]);
        
        $order = Order::create($validated);

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}
