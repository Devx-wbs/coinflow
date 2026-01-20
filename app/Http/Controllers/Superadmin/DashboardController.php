<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\LicenseActivation;
use App\Models\License;
use App\Services\DashboardChartService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{


    public function index(Request $request)
    {

        $licenses = License::with([
            'user:id,store_name',
            'activations:id,license_id,store_url,activated_at',
            'planInfo'
        ])
            ->latest()
            ->get();

        $stores = $licenses->filter(function ($license) {
            return $license->activations
                ->whereNotNull('store_url')
                ->whereNotNull('activated_at')
                ->isNotEmpty();
        });

        $todayTransactions = License::whereDate('created_at', now())->count();

        $totalAmount = $licenses->sum(function ($item) {
            return optional($item->planInfo)->price ?? 0;
        });

        $chartData = DashboardChartService::currentMonthDailyChart();

        return view('dashboard', compact(
            'licenses',
            'stores',
            'todayTransactions',
            'totalAmount',
            'chartData'
        ));
    }
}
