<?php

namespace Database\Seeders;

use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating students...');

        // Get teachers, parents, and admin users for associations
        $teachers = Teacher::take(5)->get();
        $parents = ParentModel::take(10)->get();
        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($teachers->isNotEmpty() && $parents->isNotEmpty() && $adminUser) {
            // Create students assigned to teachers and parents
            foreach ($teachers as $teacher) {
                $teacherParents = $parents->random(2);
                foreach ($teacherParents as $parent) {
                    Student::factory(rand(1, 3))->create([
                        'teacher_id' => $teacher->id,
                        'parent_id' => $parent->id,
                        'created_by' => $adminUser->id,
                        'updated_by' => $adminUser->id,
                    ]);
                }
                $this->command->info("Created students for teacher: {$teacher->user->name}");
            }
        }

        // Create additional random students
        $additionalStudents = Student::factory(20)->create();
        $this->command->info("Created {$additionalStudents->count()} additional students");

        $this->command->info('Students seeded successfully!');
    }
}
