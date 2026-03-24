<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'parent_id' => ParentModel::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'status' => fake()->randomElement(['active', 'inactive']),
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
