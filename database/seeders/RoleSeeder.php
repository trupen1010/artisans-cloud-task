<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating roles...');

        // Create predefined roles
        $roles = [
            'Admin',
            'Teacher',
            'Student',
            'Parent',
            'Manager',
            'Coordinator',
        ];

        foreach ($roles as $roleName) {
            Role::updateOrCreate(
                ['name' => $roleName],
                ['name' => $roleName]
            );
            $this->command->info("Created role: {$roleName}");
        }

        // Create additional random roles using factory
        $additionalRoles = Role::factory(5)->create();
        $this->command->info("Created {$additionalRoles->count()} additional roles");

        $this->command->info('Roles seeded successfully!');
    }
}
