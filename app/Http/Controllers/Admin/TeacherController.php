<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:teacher,view')->only(['index', 'datatable']);
        $this->middleware('CheckPermissionsMiddleware:teacher,add')->only(['create', 'store']);
        $this->middleware('CheckPermissionsMiddleware:teacher,edit')->only(['edit', 'update']);
        $this->middleware('CheckPermissionsMiddleware:teacher,delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.teachers.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        return DataTables::of(Teacher::with('user'))
            ->addColumn('name', function ($teacher) {
                return $teacher->user->name ?? '';
            })
            ->addColumn('email', function ($teacher) {
                return $teacher->user->email ?? '';
            })
            ->addColumn('status_badge', function ($teacher) {
                $class = $teacher->status === 'active' ? 'success' : 'danger';
                $text = ucfirst($teacher->status);

                return "<span class='badge bg-{$class}'>{$text}</span>";
            })
            ->addColumn('action', function ($teacher) {
                return view('admin.teachers.action', compact('teacher'))->render();
            })
            ->rawColumns(['status_badge', 'action'])
            ->escapeColumns([])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request): mixed
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $teacherRole = Role::firstOrCreate(['name' => 'Teacher']);
            $user->roles()->syncWithoutDetaching([$teacherRole->id]);

            Teacher::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Teacher $this->add_msg", 'admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Teacher $this->error_msg", 'admin.teachers.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher): View
    {
        $teacher->load('user');

        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherRequest $request, Teacher $teacher): mixed
    {
        try {
            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $teacher->user->update($userData);

            $teacherRole = Role::firstOrCreate(['name' => 'Teacher']);
            $teacher->user->roles()->syncWithoutDetaching([$teacherRole->id]);

            $teacher->update([
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Teacher $this->update_msg", 'admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Teacher $this->error_msg", 'admin.teachers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher): mixed
    {
        try {
            DB::beginTransaction();
            $teacher->delete();
            $teacher->user->delete();
            DB::commit();

            return $this->viewResponseHandler('success', "Teacher $this->delete_msg", 'admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Teacher $this->error_msg", 'admin.teachers.index');
        }
    }
}
