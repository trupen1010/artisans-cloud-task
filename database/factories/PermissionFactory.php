<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modules = ['dashboard', 'rolePermission', 'teacher', 'announcement', 'report', 'student', 'parent'];
        $permissions = ['view', 'add', 'edit', 'delete'];
        $module = fake()->randomElement($modules);
        $permission = fake()->randomElement($permissions);

        return [
            'module' => $module,
            'permission' => $permission,
            'module_display_name' => ucfirst($module),
            'permission_display_name' => 'Can '.$permission.' '.$module,
        ];
    }
}
