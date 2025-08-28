<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions for dashboard system
        $permissions = [
            // Dashboard permissions
            ['name' => 'dashboard-view', 'guard_name' => 'web'],
            
            // User management permissions
            ['name' => 'user-list', 'guard_name' => 'web'],
            ['name' => 'user-create', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'guard_name' => 'web'],
            
            // Role management permissions
            ['name' => 'role-list', 'guard_name' => 'web'],
            ['name' => 'role-create', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'guard_name' => 'web'],
            ['name' => 'role-delete', 'guard_name' => 'web'],
            
            // Permission management permissions
            ['name' => 'permission-list', 'guard_name' => 'web'],
            ['name' => 'permission-create', 'guard_name' => 'web'],
            ['name' => 'permission-edit', 'guard_name' => 'web'],
            ['name' => 'permission-delete', 'guard_name' => 'web'],
            
            // Production permissions
            ['name' => 'production-view', 'guard_name' => 'web'],
            ['name' => 'shift-list', 'guard_name' => 'web'],
            ['name' => 'shift-create', 'guard_name' => 'web'],
            ['name' => 'shift-edit', 'guard_name' => 'web'],
            ['name' => 'shift-delete', 'guard_name' => 'web'],
            
            ['name' => 'device-list', 'guard_name' => 'web'],
            ['name' => 'device-create', 'guard_name' => 'web'],
            ['name' => 'device-edit', 'guard_name' => 'web'],
            ['name' => 'device-delete', 'guard_name' => 'web'],
            
            ['name' => 'startup-list', 'guard_name' => 'web'],
            ['name' => 'startup-create', 'guard_name' => 'web'],
            ['name' => 'startup-edit', 'guard_name' => 'web'],
            ['name' => 'startup-delete', 'guard_name' => 'web'],
            
            ['name' => 'product-list', 'guard_name' => 'web'],
            ['name' => 'product-create', 'guard_name' => 'web'],
            ['name' => 'product-edit', 'guard_name' => 'web'],
            ['name' => 'product-delete', 'guard_name' => 'web'],
            
            ['name' => 'record-list', 'guard_name' => 'web'],
            ['name' => 'record-create', 'guard_name' => 'web'],
            ['name' => 'record-edit', 'guard_name' => 'web'],
            ['name' => 'record-delete', 'guard_name' => 'web'],
            
            // Report permissions
            ['name' => 'report-view', 'guard_name' => 'web'],
            ['name' => 'activity-list', 'guard_name' => 'web'],
            ['name' => 'activity-create', 'guard_name' => 'web'],
            ['name' => 'activity-edit', 'guard_name' => 'web'],
            ['name' => 'activity-delete', 'guard_name' => 'web'],
            
            ['name' => 'verification-list', 'guard_name' => 'web'],
            ['name' => 'verification-create', 'guard_name' => 'web'],
            ['name' => 'verification-edit', 'guard_name' => 'web'],
            ['name' => 'verification-delete', 'guard_name' => 'web'],
            
            // Legacy permissions (keep for backward compatibility)
            ['name' => 'start up', 'guard_name' => 'web'],
            ['name' => 'verification', 'guard_name' => 'web'],
            ['name' => 'change over', 'guard_name' => 'web'],
            ['name' => 'batch verification', 'guard_name' => 'web'],
            ['name' => 'maintenance', 'guard_name' => 'web'],
            ['name' => 'shut down', 'guard_name' => 'web'],
            ['name' => 'report', 'guard_name' => 'web'],
            ['name' => 'product not good', 'guard_name' => 'web'],
            ['name' => 'manage user', 'guard_name' => 'web'],
            ['name' => 'manage device', 'guard_name' => 'web'],
        ];

        Permission::insert($permissions);

        // Create roles
        $roles = [
            'Administrator' => 'all', // Administrator gets all permissions
            'Foreman' => [
                'dashboard-view',
                'production-view',
                'shift-list', 'shift-create', 'shift-edit',
                'device-list', 'device-create', 'device-edit',
                'startup-list', 'startup-create', 'startup-edit',
                'product-list', 'product-create', 'product-edit',
                'record-list', 'record-create', 'record-edit',
                'report-view',
                'activity-list',
                'verification-list',
                'start up', 'verification', 'change over', 'batch verification', 'maintenance', 'shut down', 'report'
            ],
            'Supervisor' => [
                'dashboard-view',
                'production-view',
                'shift-list',
                'device-list',
                'startup-list',
                'product-list', 'product-create', 'product-edit',
                'record-list', 'record-create', 'record-edit',
                'report-view',
                'activity-list',
                'verification-list',
                'start up', 'verification', 'change over', 'report'
            ],
            'Quality' => [
                'dashboard-view',
                'production-view',
                'startup-list',
                'product-list',
                'record-list',
                'report-view',
                'activity-list',
                'verification-list', 'verification-create', 'verification-edit',
                'verification', 'batch verification', 'product not good', 'report'
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
            
            if ($rolePermissions === 'all') {
                // Administrator gets all permissions
                $role->givePermissionTo(Permission::all());
            } else {
                // Give specific permissions to role
                $role->givePermissionTo($rolePermissions);
            }
        }

        // Create a default admin user if it doesn't exist
        $adminUser = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('admin123')
            ]
        );

        $adminUser->assignRole('Administrator');

        // Create sample users for other roles
        $foremanUser = User::firstOrCreate(
            ['username' => 'foreman'],
            [
                'name' => 'Foreman User',
                'password' => bcrypt('foreman123')
            ]
        );
        $foremanUser->assignRole('Foreman');

        $supervisorUser = User::firstOrCreate(
            ['username' => 'supervisor'],
            [
                'name' => 'Supervisor User',
                'password' => bcrypt('supervisor123')
            ]
        );
        $supervisorUser->assignRole('Supervisor');

        $qualityUser = User::firstOrCreate(
            ['username' => 'quality'],
            [
                'name' => 'Quality User',
                'password' => bcrypt('quality123')
            ]
        );
        $qualityUser->assignRole('Quality');
    }
}
