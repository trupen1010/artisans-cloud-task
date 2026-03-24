<?php

use App\Models\Announcement;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

describe('AdminActionStamped Trait', function () {
    beforeEach(function () {
        $this->user = User::factory()->create(['name' => 'Admin User']);
        $this->actingAs($this->user);

        $this->teacherUser = User::factory()->create(['name' => 'Teacher User']);
        $this->teacher = Teacher::factory()->create(['user_id' => $this->teacherUser->id]);
    });

    it('sets created_by when creating a student', function () {
        $student = Student::create([
            'teacher_id' => $this->teacher->id,
            'name' => 'New Student',
            'email' => 'student@test.com',
            'phone' => '1234567890',
            'status' => 'active',
        ]);

        expect($student->created_by)->toBe($this->user->id);
    });

    it('sets updated_by when updating a student', function () {
        $student = Student::factory()->create(['teacher_id' => $this->teacher->id]);
        $originalCreatedBy = $student->created_by;

        $student->update(['name' => 'Updated Name']);

        expect($student->updated_by)->toBe($this->user->id);
        expect($student->created_by)->toBe($originalCreatedBy);
    });

    it('sets created_by when creating a parent', function () {
        $parent = ParentModel::create([
            'teacher_id' => $this->teacher->id,
            'name' => 'New Parent',
            'email' => 'parent@test.com',
            'phone' => '9876543210',
            'status' => 'active',
        ]);

        expect($parent->created_by)->toBe($this->user->id);
    });

    it('sets updated_by when updating a parent', function () {
        $parent = ParentModel::factory()->create(['teacher_id' => $this->teacher->id]);
        $originalCreatedBy = $parent->created_by;

        $parent->update(['name' => 'Updated Parent']);

        expect($parent->updated_by)->toBe($this->user->id);
        expect($parent->created_by)->toBe($originalCreatedBy);
    });

    it('sets created_by when creating an announcement', function () {
        $announcement = Announcement::create([
            'title' => 'New Announcement',
            'body' => 'This is a test announcement',
            'target' => 'students',
        ]);

        expect($announcement->created_by)->toBe($this->user->id);
    });

    it('sets updated_by when updating an announcement', function () {
        $announcement = Announcement::factory()->create();
        $originalCreatedBy = $announcement->created_by;

        $announcement->update(['title' => 'Updated Title']);

        expect($announcement->updated_by)->toBe($this->user->id);
        expect($announcement->created_by)->toBe($originalCreatedBy);
    });

    it('sets deleted_by when soft deleting a student', function () {
        $student = Student::factory()->create(['teacher_id' => $this->teacher->id]);

        $student->delete();

        $student->refresh();
        expect($student->deleted_by)->toBe($this->user->id);
        expect($student->trashed())->toBeTrue();
    });

    it('sets deleted_by when soft deleting a parent', function () {
        $parent = ParentModel::factory()->create(['teacher_id' => $this->teacher->id]);

        $parent->delete();

        $parent->refresh();
        expect($parent->deleted_by)->toBe($this->user->id);
        expect($parent->trashed())->toBeTrue();
    });

    it('sets deleted_by when soft deleting an announcement', function () {
        $announcement = Announcement::factory()->create();

        $announcement->delete();

        $announcement->refresh();
        expect($announcement->deleted_by)->toBe($this->user->id);
        expect($announcement->trashed())->toBeTrue();
    });
});
