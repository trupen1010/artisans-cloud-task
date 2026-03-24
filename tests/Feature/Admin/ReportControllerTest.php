<?php

use App\Models\Announcement;
use App\Models\ParentModel;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

describe('ReportController', function () {
    beforeEach(function () {
        $this->admin = User::factory()->create(['name' => 'Admin']);
        $adminRole = Role::where('name', 'Admin')->first();
        $this->admin->roles()->attach($adminRole->id);
        $this->actingAs($this->admin);

        $this->teacherUser = User::factory()->create(['name' => 'Teacher']);
        $this->teacher = Teacher::factory()->create(['user_id' => $this->teacherUser->id]);

        // Store IDs for cleanup
        $this->studentIds = [];
        $this->parentIds = [];
        $this->announcementIds = [];
    });

    afterEach(function () {
        // Cleanup test data
        if (! empty($this->studentIds)) {
            Student::whereIn('id', $this->studentIds)->forceDelete();
        }
        if (! empty($this->parentIds)) {
            ParentModel::whereIn('id', $this->parentIds)->forceDelete();
        }
        if (! empty($this->announcementIds)) {
            Announcement::whereIn('id', $this->announcementIds)->forceDelete();
        }
    });

    describe('Students Report', function () {
        it('displays student reports page', function () {
            $response = $this->get(route('admin.reports.students'));

            $response->assertSuccessful();
            $response->assertViewIs('admin.reports.students');
            $response->assertSee('All Students');
        });

        it('returns students in datatable format with proper fields', function () {
            $students = Student::factory(3)->create(['teacher_id' => $this->teacher->id]);
            $this->studentIds = $students->pluck('id')->toArray();

            $response = $this->postJson(route('admin.reports.students.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $response->assertSuccessful();
            expect($response->json('recordsTotal'))->toBeGreaterThanOrEqual(3);
            expect(count($response->json('data', [])))->toBeGreaterThanOrEqual(3);

            // Find our created students in the response
            $data = collect($response->json('data', []));
            $studentIds = array_map('strval', $this->studentIds); // Convert to strings for comparison
            $ourStudents = $data->whereIn('id', $studentIds);
            expect($ourStudents->count())->toBeGreaterThanOrEqual(3);
        });

        it('includes all required student fields in datatable', function () {
            $student = Student::factory()->create([
                'teacher_id' => $this->teacher->id,
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->studentIds[] = $student->id;

            $response = $this->postJson(route('admin.reports.students.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $student->id);
            expect($data)->toHaveKeys([
                'id',
                'name',
                'email',
                'phone',
                'teacher_name',
                'parent_name',
                'created_by_name',
                'updated_by_name',
                'status_badge',
            ]);
            expect($data['teacher_name'])->toBe('Teacher');
            expect($data['created_by_name'])->toBe('Admin');
            expect($data['updated_by_name'])->toBe('Admin');
        });

        it('includes parent information in student report', function () {
            $parent = ParentModel::factory()->create(['teacher_id' => $this->teacher->id]);
            $this->parentIds[] = $parent->id;
            $student = Student::factory()->create([
                'teacher_id' => $this->teacher->id,
                'parent_id' => $parent->id,
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->studentIds[] = $student->id;

            $response = $this->postJson(route('admin.reports.students.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $student->id);
            expect($data['parent_name'])->toBe($parent->name);
        });

        it('displays N/A for student without parent in report', function () {
            $student = Student::factory()->create([
                'teacher_id' => $this->teacher->id,
                'parent_id' => null,
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->studentIds[] = $student->id;

            $response = $this->postJson(route('admin.reports.students.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $student->id);
            expect($data['parent_name'])->toContain('N/A');
        });

        it('shows status badge for students', function () {
            $student = Student::factory()->create([
                'teacher_id' => $this->teacher->id,
                'status' => 'active',
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->studentIds[] = $student->id;

            $response = $this->postJson(route('admin.reports.students.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $student->id);
            expect($data['status_badge'])->toContain('success');
            expect($data['status_badge'])->toContain('Active');
        });
    });

    describe('Parents Report', function () {
        it('displays parents reports page', function () {
            $response = $this->get(route('admin.reports.parents'));

            $response->assertSuccessful();
            $response->assertViewIs('admin.reports.parents');
            $response->assertSee('All Parents');
        });

        it('returns parents in datatable format with proper fields', function () {
            $parents = ParentModel::factory(3)->create(['teacher_id' => $this->teacher->id]);
            $this->parentIds = $parents->pluck('id')->toArray();

            $response = $this->postJson(route('admin.reports.parents.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $response->assertSuccessful();
            expect($response->json('recordsTotal'))->toBeGreaterThanOrEqual(3);
            expect(count($response->json('data', [])))->toBeGreaterThanOrEqual(3);

            $data = collect($response->json('data', []))->whereIn('id', $this->parentIds);
            expect($data->count())->toBe(3);
        });

        it('includes all required parent fields in datatable', function () {
            $parent = ParentModel::factory()->create([
                'teacher_id' => $this->teacher->id,
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->parentIds[] = $parent->id;

            $response = $this->postJson(route('admin.reports.parents.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $parent->id);
            expect($data)->toHaveKeys([
                'id',
                'name',
                'email',
                'phone',
                'teacher_name',
                'created_by_name',
                'updated_by_name',
                'status_badge',
            ]);
            expect($data['teacher_name'])->toBe('Teacher');
            expect($data['created_by_name'])->toBe('Admin');
            expect($data['updated_by_name'])->toBe('Admin');
        });

        it('shows status badge for parents', function () {
            $parent = ParentModel::factory()->create([
                'teacher_id' => $this->teacher->id,
                'status' => 'inactive',
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->parentIds[] = $parent->id;

            $response = $this->postJson(route('admin.reports.parents.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $parent->id);
            expect($data['status_badge'])->toContain('danger');
            expect($data['status_badge'])->toContain('Inactive');
        });
    });

    describe('Announcements Report', function () {
        it('displays announcements reports page', function () {
            $response = $this->get(route('admin.reports.announcements'));

            $response->assertSuccessful();
            $response->assertViewIs('admin.reports.announcements');
            $response->assertSee('Teacher Announcements for Students/Parents');
        });

        it('filters out teacher announcements correctly', function () {
            // Create announcements with different targets
            $studentAnn = Announcement::factory()->create(['target' => 'students', 'created_by' => $this->admin->id]);
            $parentAnn = Announcement::factory()->create(['target' => 'parents', 'created_by' => $this->admin->id]);
            $bothAnn = Announcement::factory()->create(['target' => 'both', 'created_by' => $this->admin->id]);
            $teacherAnn = Announcement::factory()->create(['target' => 'teachers', 'created_by' => $this->admin->id]);

            $this->announcementIds = [
                $studentAnn->id,
                $parentAnn->id,
                $bothAnn->id,
                $teacherAnn->id,
            ];

            $response = $this->postJson(route('admin.reports.announcements.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $response->assertSuccessful();
            $data = collect($response->json('data', []));

            // Should have at least 3 announcements (students, parents, both)
            $reportedAnnouncements = $data->whereIn('id', [$studentAnn->id, $parentAnn->id, $bothAnn->id]);
            expect($reportedAnnouncements->count())->toBe(3);

            // Teacher announcement should NOT be in report
            $teacherInReport = $data->firstWhere('id', $teacherAnn->id);
            expect($teacherInReport)->toBeNull();
        });

        it('includes all required announcement fields', function () {
            $announcement = Announcement::factory()->create([
                'target' => 'students',
                'created_by' => $this->admin->id,
                'updated_by' => $this->admin->id,
            ]);
            $this->announcementIds[] = $announcement->id;

            $response = $this->postJson(route('admin.reports.announcements.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $announcement->id);
            expect($data)->toHaveKeys([
                'id',
                'title',
                'short_body',
                'creator_name',
                'updater_name',
                'target_badge',
                'created_at',
            ]);
            expect($data['creator_name'])->toBe('Admin');
            expect($data['updater_name'])->toBe('Admin');
        });

        it('limits announcement body to 80 characters', function () {
            $longBody = 'This is a very long announcement body that should be limited to 80 characters in the report view because the report display only shows short summaries';
            $announcement = Announcement::factory()->create([
                'target' => 'students',
                'body' => $longBody,
                'created_by' => $this->admin->id,
            ]);
            $this->announcementIds[] = $announcement->id;

            $response = $this->postJson(route('admin.reports.announcements.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $announcement->id);
            // Str::limit adds "..." at the end if truncated, so max length is 80 + 3
            expect(strlen(strip_tags($data['short_body'])))->toBeLessThanOrEqual(83);
        });

        it('shows target badge correctly', function () {
            $studentAnn = Announcement::factory()->create(['target' => 'students', 'created_by' => $this->admin->id]);
            $parentAnn = Announcement::factory()->create(['target' => 'parents', 'created_by' => $this->admin->id]);
            $bothAnn = Announcement::factory()->create(['target' => 'both', 'created_by' => $this->admin->id]);

            $this->announcementIds = [$studentAnn->id, $parentAnn->id, $bothAnn->id];

            $response = $this->postJson(route('admin.reports.announcements.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []));

            expect($data->firstWhere('id', $studentAnn->id)['target_badge'])->toContain('primary');
            expect($data->firstWhere('id', $parentAnn->id)['target_badge'])->toContain('warning');
            expect($data->firstWhere('id', $bothAnn->id)['target_badge'])->toContain('success');
        });

        it('displays N/A for updater if announcement not updated', function () {
            $announcement = Announcement::factory()->create([
                'target' => 'students',
                'created_by' => $this->admin->id,
                'updated_by' => null,
            ]);
            $this->announcementIds[] = $announcement->id;

            $response = $this->postJson(route('admin.reports.announcements.datatable'), [
                'draw' => 1,
                'start' => 0,
                'length' => 100,
            ]);

            $data = collect($response->json('data', []))->firstWhere('id', (string) $announcement->id);
            expect($data['updater_name'])->toContain('N/A');
        });
    });
});
