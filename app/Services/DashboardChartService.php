<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\License;

class DashboardChartService
{
    public static function currentMonthDailyChart()
    {
        $startDate = now()->startOfMonth();
        $endDate   = now();

        $labels = [];
        $transactions = [];
        $earnings = [];

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $labels[] = $date->format('j M');

            $transactionCount = License::whereDate(
                'created_at',
                $date->toDateString()
            )->count();

            $earningAmount = License::whereDate(
                'created_at',
                $date->toDateString()
            )
            ->with('planInfo')
            ->get()
            ->sum(fn ($license) => $license->planInfo->price ?? 0);

            $transactions[] = $transactionCount;
            $earnings[] = round($earningAmount, 2);
        }

        return [
            'labels'       => $labels,
            'transactions' => $transactions,
            'earnings'     => $earnings,
        ];
    }
}
