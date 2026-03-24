<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating users...');

        // Create admin users
        $adminUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($adminUsers as $adminData) {
            User::updateOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );
            $this->command->info("Created admin user: {$adminData['email']}");
        }

        // Create teacher users
        $teacherUsers = [
            [
                'name' => 'John Doe',
                'email' => 'john.teacher@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.teacher@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($teacherUsers as $teacherData) {
            User::updateOrCreate(
                ['email' => $teacherData['email']],
                $teacherData
            );
            $this->command->info("Created teacher user: {$teacherData['email']}");
        }

        // Create additional random users using factory
        $additionalUsers = User::factory(20)->create();
        $this->command->info("Created {$additionalUsers->count()} additional users");

        $this->command->info('Users seeded successfully!');
    }
}
