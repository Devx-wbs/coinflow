<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::whereIn('name', [
            'license_management',
            'license_managment'
        ])->delete();
        $permissions = [
            // Dashboard
            'dashboard',
            'logout',

            // Plan Management
            'plans-index',
            'plan-create',
            'plan-store',
            'plan-edit',
            'plan-update',
            'plan-destroy',

            // Merchant / Modules
            'merchant-contact',
            'subscribe-store',
            'license-managment',
            'global-stats',
            'logs-error',
            'update-tracker',
            'support',
            'push-notice',

            // Global Setting
            'global-setting',

            // User Role & Permission
            'user-role-permission',
            'user-role-permission.create',
            'user-role-permission.store',
            'user-role-permission.edit',
            'user-role-permission.update',
            'user-role-permission.destroy',
            //logs 

            'logs.deleteAll',
            'logs.index',
            'logs.show',
            'logs.delete',
            'logs.export',

            //support tickets

            'support.reply',
            'support',
            'support.create',
            'support.store',
            'support.show',
            'support.destroy',
            'support.assign',
            'support.updateStatus',

            // push notification

            'push.notice.index',
            'push.notice.store',
            'push.notice.show',
            'push.notice.send',
            'push.notice.update',
            'push.notice.edit',

            // plugin update tracker
            'update-tracker.index',
            'update-tracker.add',
            'update-tracker.delete',
            'update-tracker.export',
            'update-tracker.sendNotice'


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Roles
        $admin    = Role::firstOrCreate(['name' => 'admin']);
        $subAdmin = Role::firstOrCreate(['name' => 'sub_admin']);
        $support  = Role::firstOrCreate(['name' => 'support']);
        $user     = Role::firstOrCreate(['name' => 'user']);

        // Admin → all permissions
        $admin->syncPermissions(Permission::all());

        // Sub Admin → limited
        $subAdmin->syncPermissions([
            'dashboard',
            'logout'
        ]);

        // Support → support only
        $support->syncPermissions([
            'dashboard',
            'support',
            'logout'
        ]);
    }
}
