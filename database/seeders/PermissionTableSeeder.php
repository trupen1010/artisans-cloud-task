<?php

namespace Database\Seeders;

use App\Models\Permission;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Throwable;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Throwable
     */
    public function run(): void
    {
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Permission::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->command->info('Permission table truncated successfully');

            DB::beginTransaction();
            $modulePermissions = [

                // ? Dashboard Permissions
                'dashboard' => ['permissions' => ['view'], 'permission_display_name' => ['Can View Dashboard'], 'module_display_name' => 'Dashboard'],
                // ? Role Permissions
                'rolePermission' => ['permissions' => ['view', 'add', 'edit', 'delete'], 'permission_display_name' => ['Can view role details', 'Can add a role', 'Can modify a role', 'Can delete a role'], 'module_display_name' => 'Role Permission'],
                // ? Teacher Permissions
                'teacher' => ['permissions' => ['view', 'add', 'edit', 'delete'], 'permission_display_name' => ['Can view teachers', 'Can add a teacher', 'Can modify a teacher', 'Can delete a teacher'], 'module_display_name' => 'Teacher'],
                // ? Announcement Permissions
                'announcement' => ['permissions' => ['view', 'add', 'edit', 'delete'], 'permission_display_name' => ['Can view announcements', 'Can add an announcement', 'Can modify an announcement', 'Can delete an announcement'], 'module_display_name' => 'Announcement'],
            ];

            foreach ($modulePermissions as $module => $moduleData) {
                $permissions = $moduleData['permissions'];
                $permissionDisplayNames = $moduleData['permission_display_name'];
                $moduleDisplayName = $moduleData['module_display_name'];
                $this->command->info('Seeding permission data for module: '.$module);
                foreach ($permissions as $index => $permission) {
                    Permission::updateOrCreate(
                        ['module' => $module, 'permission' => $permission],
                        [
                            'module' => $module,
                            'permission' => $permission,
                            'module_display_name' => $moduleDisplayName,
                            'permission_display_name' => $permissionDisplayNames[$index],
                        ]
                    );
                }
            }
            $this->command->info('Permission data seeded successfully');
            Artisan::call('optimize:clear');
            $this->command->info('Optimize cleared successfully');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->command->error('Error occurred while seeding permission data: '.$e->getMessage());
            throw $e;
        }
    }
}
