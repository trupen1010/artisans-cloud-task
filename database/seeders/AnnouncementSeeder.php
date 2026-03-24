<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating announcements...');

        // Get admin and teacher users
        $adminUsers = User::whereIn('email', [
            'admin@example.com',
            'john.teacher@example.com',
            'jane.teacher@example.com',
        ])->get();

        if ($adminUsers->isNotEmpty()) {
            // Create specific announcements
            $specificAnnouncements = [
                [
                    'title' => 'Welcome to the New Academic Year',
                    'body' => 'We are excited to welcome all students and parents to the new academic year. Please check your schedules and be prepared for the upcoming classes.',
                    'target' => 'both',
                ],
                [
                    'title' => 'Parent-Teacher Meeting Schedule',
                    'body' => 'The parent-teacher meetings are scheduled for next month. Please check your email for specific times and dates.',
                    'target' => 'parents',
                ],
                [
                    'title' => 'Upcoming Exams Notice',
                    'body' => 'Mid-term exams will be conducted next week. Please ensure you are well-prepared and have all necessary materials.',
                    'target' => 'students',
                ],
                [
                    'title' => 'Staff Development Day',
                    'body' => 'There will be a staff development day next Friday. Classes will be suspended for that day.',
                    'target' => 'teachers',
                ],
            ];

            foreach ($specificAnnouncements as $announcementData) {
                $user = $adminUsers->random();
                Announcement::factory()->create([
                    'title' => $announcementData['title'],
                    'body' => $announcementData['body'],
                    'target' => $announcementData['target'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]);
                $this->command->info("Created announcement: {$announcementData['title']}");
            }
        }

        // Create additional random announcements
        $additionalAnnouncements = Announcement::factory(15)->create();
        $this->command->info("Created {$additionalAnnouncements->count()} additional announcements");

        $this->command->info('Announcements seeded successfully!');
    }
}
