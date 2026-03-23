<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ParentModel;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:report,view');
    }

    public function students(): View
    {
        return view('admin.reports.students');
    }

    /**
     * @throws Exception
     */
    public function studentsDatatable(): JsonResponse
    {
        $query = Student::with(['teacher.user', 'parent']);

        return DataTables::of($query)
            ->addColumn('teacher_name', function ($student) {
                return $student->teacher->user->name ?? '';
            })
            ->addColumn('parent_name', function ($student) {
                return $student->parent->name ?? '<span class="text-muted">N/A</span>';
            })
            ->addColumn('status_badge', function ($student) {
                $class = $student->status === 'active' ? 'success' : 'danger';
                $text = ucfirst($student->status);

                return "<span class='badge bg-{$class}'>{$text}</span>";
            })
            ->rawColumns(['parent_name', 'status_badge'])
            ->escapeColumns([])
            ->make();
    }

    public function parents(): View
    {
        return view('admin.reports.parents');
    }

    /**
     * @throws Exception
     */
    public function parentsDatatable(): JsonResponse
    {
        $query = ParentModel::with('teacher.user');

        return DataTables::of($query)
            ->addColumn('teacher_name', function ($parent) {
                return $parent->teacher->user->name ?? '';
            })
            ->addColumn('status_badge', function ($parent) {
                $class = $parent->status === 'active' ? 'success' : 'danger';
                $text = ucfirst($parent->status);

                return "<span class='badge bg-{$class}'>{$text}</span>";
            })
            ->rawColumns(['status_badge'])
            ->escapeColumns([])
            ->make();
    }

    public function teacherAnnouncements(): View
    {
        return view('admin.reports.announcements');
    }

    /**
     * @throws Exception
     */
    public function announcementsDatatable(): JsonResponse
    {
        $query = Announcement::with('creator')
            ->whereIn('target', ['students', 'parents', 'both']);

        return DataTables::of($query)
            ->addColumn('creator_name', function ($announcement) {
                return $announcement->creator->name ?? '';
            })
            ->addColumn('short_body', function ($announcement) {
                return Str::limit($announcement->body, 80);
            })
            ->addColumn('target_badge', function ($announcement) {
                $colors = ['students' => 'primary', 'parents' => 'warning', 'both' => 'success'];
                $color = $colors[$announcement->target] ?? 'secondary';
                $text = ucfirst($announcement->target);

                return "<span class='badge bg-{$color}'>{$text}</span>";
            })
            ->rawColumns(['target_badge'])
            ->escapeColumns([])
            ->make();
    }
}
