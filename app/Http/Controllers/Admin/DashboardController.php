<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $announcements = collect();

        if (Auth::check()) {
            $user = User::with('roles', 'teacher')->find(Auth::id());

            $isTeacher = $user && ($user->roles->contains(function ($role) {
                return strtolower($role->name) === 'teacher';
            }) || $user->teacher !== null);

            if ($isTeacher) {
                $announcements = Announcement::with('creator:id,name')
                    ->where('target', 'teachers')
                    ->latest()
                    ->get();
            }
        }

        return view('admin.dashboard', compact('announcements'));
    }
}
