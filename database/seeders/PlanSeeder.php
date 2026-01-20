<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::firstOrCreate(['name' => 'Free'], [
            'description' => 'Free plan with basic features',
            'price' => 0,
            'duration' => 0,
            'duration_type' => 'months',
            'license_type' => 'single_site',
            'max_activations' => 1,
            'auto_generate_license' => false,
            'features' => json_encode(['basic']),
            'is_active' => true,
            'trial_days' => null
        ]);
    }
}
