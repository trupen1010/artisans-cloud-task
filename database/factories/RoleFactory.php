<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Admin',
                'Teacher',
                'Student',
                'Parent',
                'Manager',
                'Coordinator',
                'Assistant',
            ]),
        ];
    }

    /**
     * Create a specific admin role.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
        ]);
    }

    /**
     * Create a specific teacher role.
     */
    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Teacher',
        ]);
    }

    /**
     * Create a specific student role.
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Student',
        ]);
    }

    /**
     * Create a specific parent role.
     */
    public function parent(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Parent',
        ]);
    }
}
