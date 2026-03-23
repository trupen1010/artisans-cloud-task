<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentRequest;
use App\Models\ParentModel;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:student,view')->only(['index', 'datatable']);
        $this->middleware('CheckPermissionsMiddleware:student,add')->only(['create', 'store']);
        $this->middleware('CheckPermissionsMiddleware:student,edit')->only(['edit', 'update']);
        $this->middleware('CheckPermissionsMiddleware:student,delete')->only(['destroy']);
    }

    private function teacherId(): int
    {
        return Auth::user()->teacher->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teacher.students.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        $query = Student::with(['teacher', 'parent'])
            ->where('teacher_id', $this->teacherId());

        return DataTables::of($query)
            ->addColumn('parent_name', function ($student) {
                return $student->parent->name ?? '<span class="text-muted">N/A</span>';
            })
            ->addColumn('status_badge', function ($student) {
                $class = $student->status === 'active' ? 'success' : 'danger';
                $text = ucfirst($student->status);

                return "<span class='badge bg-{$class}'>{$text}</span>";
            })
            ->addColumn('action', function ($student) {
                return view('teacher.students.action', compact('student'))->render();
            })
            ->rawColumns(['parent_name', 'status_badge', 'action'])
            ->escapeColumns([])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parents = ParentModel::where('teacher_id', $this->teacherId())
            ->where('status', 'active')
            ->get();

        return view('teacher.students.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request): mixed
    {
        try {
            DB::beginTransaction();

            Student::create([
                'teacher_id' => $this->teacherId(),
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Student $this->add_msg", 'teacher.students.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Student creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Student $this->error_msg", 'teacher.students.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        abort_if($student->teacher_id !== $this->teacherId(), 403);

        $parents = ParentModel::where('teacher_id', $this->teacherId())
            ->where('status', 'active')
            ->get();

        return view('teacher.students.edit', compact('student', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student): mixed
    {
        abort_if($student->teacher_id !== $this->teacherId(), 403);

        try {
            DB::beginTransaction();

            $student->update([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Student $this->update_msg", 'teacher.students.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Student update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Student $this->error_msg", 'teacher.students.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): mixed
    {
        abort_if($student->teacher_id !== $this->teacherId(), 403);

        try {
            DB::beginTransaction();
            $student->delete();
            DB::commit();

            return $this->viewResponseHandler('success', "Student $this->delete_msg", 'teacher.students.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Student deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Student $this->error_msg", 'teacher.students.index');
        }
    }
}
