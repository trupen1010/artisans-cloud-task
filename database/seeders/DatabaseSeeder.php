<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Seed in the correct order to respect foreign key relationships
        $this->call([
            // First, create users and permissions
            UserSeeder::class,
            PermissionTableSeeder::class,
            RoleSeeder::class,

            // Then create the main entities
            TeacherSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,

            // Create content
            AnnouncementSeeder::class,

            // Finally, create the relationship mappings
            RolePermissionSeeder::class,
            AdminRoleSeeder::class,
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
    }
}
