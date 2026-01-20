<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure the role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@coinflow.com'], 
            [
                'name' => 'Admin',
                'password' => 'Admin@123',
                'status' => 'active',
                'role' => 1
            ]
        );

        // Assign role
        $admin->assignRole($adminRole);
    }
}