<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('creator:id,name')
            ->where('target', 'teachers')
            ->latest()
            ->get();

        return view('teacher.dashboard', compact('announcements'));
    }
}
