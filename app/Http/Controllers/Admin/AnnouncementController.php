<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:announcement,view')->only(['index', 'datatable']);
        $this->middleware('CheckPermissionsMiddleware:announcement,add')->only(['create', 'store']);
        $this->middleware('CheckPermissionsMiddleware:announcement,edit')->only(['edit', 'update']);
        $this->middleware('CheckPermissionsMiddleware:announcement,delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.announcements.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        return DataTables::of(Announcement::with('creator')->where('target', 'teachers'))
            ->addColumn('creator_name', function ($announcement) {
                return $announcement->creator->name ?? '';
            })
            ->addColumn('short_body', function ($announcement) {
                return Str::limit($announcement->body, 80);
            })
            ->addColumn('target_badge', function () {
                return "<span class='badge bg-info'>Teachers</span>";
            })
            ->addColumn('action', function ($announcement) {
                return view('admin.announcements.action', compact('announcement'))->render();
            })
            ->rawColumns(['target_badge', 'action'])
            ->escapeColumns([])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request): mixed
    {
        try {
            DB::beginTransaction();

            Announcement::create([
                'created_by' => Auth::id(),
                'title' => $request->title,
                'body' => $request->body,
                'target' => 'teachers',
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Announcement $this->add_msg", 'admin.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Announcement creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement $this->error_msg", 'admin.announcements.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, Announcement $announcement): mixed
    {
        try {
            DB::beginTransaction();

            $announcement->update([
                'title' => $request->title,
                'body' => $request->body,
                'target' => 'teachers',
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Announcement $this->update_msg", 'admin.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Announcement update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement $this->error_msg", 'admin.announcements.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement): mixed
    {
        try {
            DB::beginTransaction();
            $announcement->delete();
            DB::commit();

            return $this->viewResponseHandler('success', "Announcement $this->delete_msg", 'admin.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Announcement deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement $this->error_msg", 'admin.announcements.index');
        }
    }
}
