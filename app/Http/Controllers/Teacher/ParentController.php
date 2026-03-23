<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\ParentRequest;
use App\Models\ParentModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ParentController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:parent,view')->only(['index', 'datatable']);
        $this->middleware('CheckPermissionsMiddleware:parent,add')->only(['create', 'store']);
        $this->middleware('CheckPermissionsMiddleware:parent,edit')->only(['edit', 'update']);
        $this->middleware('CheckPermissionsMiddleware:parent,delete')->only(['destroy']);
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
        return view('teacher.parents.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        $query = ParentModel::where('teacher_id', $this->teacherId());

        return DataTables::of($query)
            ->addColumn('status_badge', function ($parent) {
                $class = $parent->status === 'active' ? 'success' : 'danger';
                $text = ucfirst($parent->status);

                return "<span class='badge bg-{$class}'>{$text}</span>";
            })
            ->addColumn('action', function ($parent) {
                return view('teacher.parents.action', compact('parent'))->render();
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
        return view('teacher.parents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParentRequest $request): mixed
    {
        try {
            DB::beginTransaction();

            ParentModel::create([
                'teacher_id' => $this->teacherId(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Parent $this->add_msg", 'teacher.parents.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Parent creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Parent $this->error_msg", 'teacher.parents.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentModel $parent): View
    {
        abort_if($parent->teacher_id !== $this->teacherId(), 403);

        return view('teacher.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParentRequest $request, ParentModel $parent): mixed
    {
        abort_if($parent->teacher_id !== $this->teacherId(), 403);

        try {
            DB::beginTransaction();

            $parent->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Parent $this->update_msg", 'teacher.parents.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Parent update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Parent $this->error_msg", 'teacher.parents.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentModel $parent): mixed
    {
        abort_if($parent->teacher_id !== $this->teacherId(), 403);

        try {
            DB::beginTransaction();
            $parent->delete();
            DB::commit();

            return $this->viewResponseHandler('success', "Parent $this->delete_msg", 'teacher.parents.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Parent deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Parent $this->error_msg", 'teacher.parents.index');
        }
    }
}
