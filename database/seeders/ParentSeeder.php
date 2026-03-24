<?php

namespace Database\Seeders;

use App\Models\ParentModel;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating parents...');

        // Get some teachers and admin users for associations
        $teachers = Teacher::take(5)->get();
        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($teachers->isNotEmpty() && $adminUser) {
            // Create specific parent records
            foreach ($teachers as $teacher) {
                ParentModel::factory(rand(2, 4))->create([
                    'teacher_id' => $teacher->id,
                    'created_by' => $adminUser->id,
                    'updated_by' => $adminUser->id,
                ]);
                $this->command->info("Created parents for teacher: {$teacher->user->name}");
            }
        }

        // Create additional random parents
        $additionalParents = ParentModel::factory(15)->create();
        $this->command->info("Created {$additionalParents->count()} additional parents");

        $this->command->info('Parents seeded successfully!');
    }
}
