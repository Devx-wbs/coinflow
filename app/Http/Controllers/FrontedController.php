<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\License;
use App\Models\Plan;
use App\Models\PluginVersion;
use Carbon\Carbon;



class FrontedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        if (!Auth::check()) {
            $plans = Plan::where('is_active', 1)->get();
            return view('home-fronted.fronted', compact('plans'));
        }

        $user = Auth::user();
        // Active subscription nikaalo
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->with('plan') // Plan relation
            ->first();

        // Active plans ko fetch karenge
        $plans = Plan::where('is_active', 1)->get();
        $license = License::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('expiration_date', '>=', Carbon::today())
            ->first();

        $latestPlugin = PluginVersion::orderBy('released_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        return view('home-fronted.fronted', compact('plans', 'subscription', 'license', 'latestPlugin'));
    }



    public function plan_detail()
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        // 2. Active subscription nikaalo
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->with('plan')
            ->first();

        if (!$subscription) {
            // Agar active subscription nahi mila
            return redirect('/')->with('error', 'Please purchase a plan to access this page.');
        }

        // 3. License nikaalo (agar hai)
        $license = License::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('expiration_date', '>=', Carbon::today())
            ->first();

        // 4. Order history (sabhi subscriptions)
        $orders = Subscription::where('user_id', $user->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();

        $latestPlugin = PluginVersion::orderBy('released_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        return view('home-fronted.plan-detail', compact('subscription', 'license', 'orders', 'latestPlugin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
