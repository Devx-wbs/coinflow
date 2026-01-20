<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Agar login hi nahi hai
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Check active subscription
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today()) // expired na ho
            ->first();

        if (!$activeSubscription) {
            return redirect('/')->with('error', 'You need to buy a subscription plan to access this page.');
        }

        return $next($request);
    }
}
