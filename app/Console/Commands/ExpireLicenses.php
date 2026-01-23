<?php

namespace App\Console\Commands;

use App\Models\License;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireLicenses extends Command
{
   protected $signature = 'license:expire';
    protected $description = 'Expire licenses whose expiry date has passed';

    public function handle()
    {
       
         $now =  Carbon::today();

        $expiredCount = License::where('status', 'active')
            ->where('expiry_date', '<', $now)
            ->update([
                'status' => 'expired'
            ]);

        $this->info("Expired {$expiredCount} licenses successfully.");

        return Command::SUCCESS;
    }
}
