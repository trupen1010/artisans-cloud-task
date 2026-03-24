<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Assigning permissions to roles...');

        // Get roles and permissions
        $adminRole = Role::where('name', 'Admin')->first();
        $teacherRole = Role::where('name', 'Teacher')->first();
        $studentRole = Role::where('name', 'Student')->first();
        $parentRole = Role::where('name', 'Parent')->first();

        $allPermissions = Permission::all();

        if ($adminRole && $allPermissions->isNotEmpty()) {
            // Admin gets all permissions
            foreach ($allPermissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $adminRole->id,
                    'permission_id' => $permission->id,
                ]);
            }
            $this->command->info('Assigned all permissions to Admin role');
        }

        if ($teacherRole && $allPermissions->isNotEmpty()) {
            // Teacher gets specific permissions
            $teacherPermissions = $allPermissions->whereIn('module', [
                'dashboard', 'announcement', 'student', 'parent',
            ]);

            foreach ($teacherPermissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $teacherRole->id,
                    'permission_id' => $permission->id,
                ]);
            }
            $this->command->info('Assigned teacher permissions to Teacher role');
        }

        if ($studentRole && $allPermissions->isNotEmpty()) {
            // Student gets limited permissions
            $studentPermissions = $allPermissions->where('module', 'dashboard')
                ->where('permission', 'view');

            foreach ($studentPermissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $studentRole->id,
                    'permission_id' => $permission->id,
                ]);
            }
            $this->command->info('Assigned student permissions to Student role');
        }

        if ($parentRole && $allPermissions->isNotEmpty()) {
            // Parent gets limited permissions
            $parentPermissions = $allPermissions->whereIn('module', ['dashboard', 'announcement'])
                ->where('permission', 'view');

            foreach ($parentPermissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $parentRole->id,
                    'permission_id' => $permission->id,
                ]);
            }
            $this->command->info('Assigned parent permissions to Parent role');
        }

        // Create some random role-permission assignments
        $otherRoles = Role::whereNotIn('name', ['Admin', 'Teacher', 'Student', 'Parent'])->get();
        foreach ($otherRoles as $role) {
            $randomPermissions = $allPermissions->random(rand(3, 8));
            foreach ($randomPermissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                ]);
            }
            $this->command->info("Assigned random permissions to {$role->name} role");
        }

        $this->command->info('Role permissions seeded successfully!');
    }
}
