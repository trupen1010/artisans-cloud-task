<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AnnouncementRequest;
use App\Jobs\SendAnnouncementEmailJob;
use App\Models\Announcement;
use App\Models\ParentModel;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
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

    private function teacherId(): int
    {
        return Auth::user()->teacher->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teacher.announcements.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        $query = Announcement::with('creator')
            ->where('created_by', Auth::id())
            ->whereIn('target', ['students', 'parents', 'both']);

        return DataTables::of($query)
            ->addColumn('short_body', fn ($a) => Str::limit($a->body, 80))
            ->addColumn('target_badge', function ($announcement) {
                $colors = ['students' => 'primary', 'parents' => 'warning', 'both' => 'success'];
                $color = $colors[$announcement->target] ?? 'secondary';

                return "<span class='badge bg-{$color}'>".ucfirst($announcement->target).'</span>';
            })
            ->addColumn('action', fn ($announcement) => view('teacher.announcements.action', compact('announcement'))->render())
            ->rawColumns(['target_badge', 'action'])
            ->escapeColumns([])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('teacher.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request): mixed
    {
        try {
            DB::beginTransaction();

            $announcement = Announcement::create([
                'created_by' => Auth::id(),
                'title' => $request->title,
                'body' => $request->body,
                'target' => $request->target,
            ]);

            DB::commit();

            // Resolve recipients and dispatch queue job
            $recipients = $this->resolveRecipients($request->target);
            if ($recipients->isNotEmpty()) {
                SendAnnouncementEmailJob::dispatch($announcement, $recipients);
            }

            return $this->viewResponseHandler('success', "Announcement {$this->add_msg}", 'teacher.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher announcement creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement {$this->error_msg}", 'teacher.announcements.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement): View
    {
        abort_if($announcement->created_by !== Auth::id(), 403);

        return view('teacher.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, Announcement $announcement): mixed
    {
        abort_if($announcement->created_by !== Auth::id(), 403);

        try {
            DB::beginTransaction();

            $announcement->update([
                'title' => $request->title,
                'body' => $request->body,
                'target' => $request->target,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            return $this->viewResponseHandler('success', "Announcement {$this->update_msg}", 'teacher.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher announcement update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement {$this->error_msg}", 'teacher.announcements.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement): mixed
    {
        abort_if($announcement->created_by !== Auth::id(), 403);

        try {
            DB::beginTransaction();
            $announcement->delete();
            DB::commit();

            return $this->viewResponseHandler('success', "Announcement {$this->delete_msg}", 'teacher.announcements.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Teacher announcement deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "Announcement {$this->error_msg}", 'teacher.announcements.index');
        }
    }

    /**
     * Resolves a flat collection of recipients based on target.
     *
     * @return Collection<int, array{name: string, email: string}>
     */
    private function resolveRecipients(string $target): Collection
    {
        $teacherId = $this->teacherId();
        $recipients = collect();

        if (in_array($target, ['students', 'both'])) {
            Student::where('teacher_id', $teacherId)
                ->where('status', 'active')
                ->whereNotNull('email')
                ->get(['name', 'email'])
                ->each(fn ($s) => $recipients->push(['name' => $s->name, 'email' => $s->email]));
        }

        if (in_array($target, ['parents', 'both'])) {
            ParentModel::where('teacher_id', $teacherId)
                ->where('status', 'active')
                ->whereNotNull('email')
                ->get(['name', 'email'])
                ->each(fn ($p) => $recipients->push(['name' => $p->name, 'email' => $p->email]));
        }

        return $recipients;
    }
}
