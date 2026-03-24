<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = User::with('roles', 'teacher')->find(Auth::id());
        $isAdmin = $user && $user->hasRole('admin');
        $isTeacher = $user && ($user->hasRole('teacher') || $user->teacher !== null);

        $announcements = collect();
        $statistics = null;

        if ($isAdmin) {
            // Admin statistics
            $statistics = [
                'teachers' => Teacher::count(),
                'students' => Student::count(),
                'parents' => ParentModel::count(),
                'announcements' => Announcement::count(),
            ];

            // Get recent announcements for admin
            $announcements = Announcement::with('creator:id,name')
                ->latest()
                ->limit(5)
                ->get();
        } elseif ($isTeacher) {
            // Get announcements for teachers
            $announcements = Announcement::with('creator:id,name')
                ->where('target', 'teachers')
                ->latest()
                ->get();
        }

        return view('admin.dashboard', compact('announcements', 'statistics'));
    }
}
