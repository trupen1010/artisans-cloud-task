<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Assigning roles to admin users...');

        // Get admin users and roles
        $adminUsers = User::whereIn('email', [
            'admin@example.com',
            'superadmin@example.com',
        ])->get();

        $adminRole = Role::where('name', 'Admin')->first();
        $teacherRole = Role::where('name', 'Teacher')->first();

        // Assign admin role to admin users
        if ($adminRole && $adminUsers->isNotEmpty()) {
            foreach ($adminUsers as $user) {
                AdminRole::updateOrCreate([
                    'admin_id' => $user->id,
                    'role_id' => $adminRole->id,
                ]);
                $this->command->info("Assigned Admin role to user: {$user->email}");
            }
        }

        // Assign teacher role to teacher users
        $teacherUsers = User::whereIn('email', [
            'john.teacher@example.com',
            'jane.teacher@example.com',
        ])->get();

        if ($teacherRole && $teacherUsers->isNotEmpty()) {
            foreach ($teacherUsers as $user) {
                AdminRole::updateOrCreate([
                    'admin_id' => $user->id,
                    'role_id' => $teacherRole->id,
                ]);
                $this->command->info("Assigned Teacher role to user: {$user->email}");
            }
        }

        // Create some random admin-role assignments
        $otherUsers = User::whereNotIn('email', [
            'admin@example.com',
            'superadmin@example.com',
            'john.teacher@example.com',
            'jane.teacher@example.com',
        ])->take(10)->get();

        $otherRoles = Role::whereNotIn('name', ['Admin', 'Teacher'])->get();

        foreach ($otherUsers as $user) {
            if ($otherRoles->isNotEmpty()) {
                $randomRole = $otherRoles->random();
                AdminRole::updateOrCreate([
                    'admin_id' => $user->id,
                    'role_id' => $randomRole->id,
                ]);
                $this->command->info("Assigned {$randomRole->name} role to user: {$user->email}");
            }
        }

        $this->command->info('Admin roles seeded successfully!');
    }
}
