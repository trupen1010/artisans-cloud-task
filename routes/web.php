<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ParentController;
use App\Http\Controllers\Teacher\StudentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['prefix' => 'admin'], static function () {
    // ? Auth
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'index')->name('admin.login');
        Route::post('auth', 'auth')->name('admin.auth');
        Route::get('logout', 'logout')->name('admin.logout');
    });

    Route::group(['middleware' => ['auth-web']], static function () {
        // ? Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // ? User Access Control
        Route::post('user-access-control/datatable', [UserAccessController::class, 'datatable'])->name('admin.user.access.control.datatable');
        Route::resource('user-access-control', UserAccessController::class)->names([
            'index' => 'admin.user.access.control.index',
            'create' => 'admin.user.access.control.create',
            'store' => 'admin.user.access.control.store',
            'edit' => 'admin.user.access.control.edit',
            'update' => 'admin.user.access.control.update',
            'destroy' => 'admin.user.access.control.destroy',
        ])->except(['show']);

        // ? Teachers
        Route::post('teachers/datatable', [TeacherController::class, 'datatable'])->name('admin.teachers.datatable');
        Route::resource('teachers', TeacherController::class)->names([
            'index' => 'admin.teachers.index',
            'create' => 'admin.teachers.create',
            'store' => 'admin.teachers.store',
            'edit' => 'admin.teachers.edit',
            'update' => 'admin.teachers.update',
            'destroy' => 'admin.teachers.destroy',
        ])->except(['show']);

        // ? Announcements
        Route::post('announcements/datatable', [AnnouncementController::class, 'datatable'])->name('admin.announcements.datatable');
        Route::resource('announcements', AnnouncementController::class)->names([
            'index' => 'admin.announcements.index',
            'create' => 'admin.announcements.create',
            'store' => 'admin.announcements.store',
            'edit' => 'admin.announcements.edit',
            'update' => 'admin.announcements.update',
            'destroy' => 'admin.announcements.destroy',
        ])->except(['show']);

        // Admin Reports - Read Only
        Route::get('reports/students', [ReportController::class, 'students'])->name('admin.reports.students');
        Route::post('reports/students/datatable', [ReportController::class, 'studentsDatatable'])->name('admin.reports.students.datatable');

        Route::get('reports/parents', [ReportController::class, 'parents'])->name('admin.reports.parents');
        Route::post('reports/parents/datatable', [ReportController::class, 'parentsDatatable'])->name('admin.reports.parents.datatable');

        Route::get('reports/announcements', [ReportController::class, 'teacherAnnouncements'])->name('admin.reports.announcements');
        Route::post('reports/announcements/datatable', [ReportController::class, 'announcementsDatatable'])->name('admin.reports.announcements.datatable');

        // Optimize Clear
        Route::get('settings/optimize', [SettingController::class, 'optimize'])->name('admin.settings.general.optimize');
    });
});

Route::middleware(['auth-web', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(static function () {
    Route::get('dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    Route::post('students/datatable', [StudentController::class, 'datatable'])->name('students.datatable');
    Route::resource('students', StudentController::class)->except(['show']);

    Route::post('parents/datatable', [ParentController::class, 'datatable'])->name('parents.datatable');
    Route::resource('parents', ParentController::class)->except(['show']);
});
