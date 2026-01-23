<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ExpireLicenses;
// use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    
    /**
     * Register commands
     */
    protected $commands = [
        ExpireLicenses::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
         
        $schedule->command('license:expire')
            ->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
