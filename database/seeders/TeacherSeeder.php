<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating teachers...');

        // Get teacher users
        $teacherUsers = User::whereIn('email', [
            'john.teacher@example.com',
            'jane.teacher@example.com',
        ])->get();

        // Create teacher profiles for specific users
        foreach ($teacherUsers as $user) {
            Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'phone' => fake()->phoneNumber(),
                    'status' => 'active',
                ]
            );
            $this->command->info("Created teacher profile for user: {$user->email}");
        }

        // Create additional random teachers using factory
        $additionalTeachers = Teacher::factory(8)->create();
        $this->command->info("Created {$additionalTeachers->count()} additional teachers");

        $this->command->info('Teachers seeded successfully!');
    }
}
