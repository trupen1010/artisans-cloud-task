@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Dashboard',
    'breadcrumbs' => [[
        'title' => 'Dashboard',
        'url' => null,
    ]],
])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Announcements</h4>
                </div>
                <div class="card-body">
                    @forelse($announcements as $announcement)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                <h5 class="mb-0">{{ $announcement->title }}</h5>
                                <small class="text-muted">{{ $announcement->created_at->format('d M, Y h:i A') }}</small>
                            </div>
                            <p class="text-muted mb-2">{{ $announcement->body }}</p>
                            <small class="text-muted">Posted by: {{ $announcement->creator->name ?? 'System' }}</small>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <h6 class="mb-1">No announcements available</h6>
                            <p class="text-muted mb-0">New updates will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
