@extends('admin.layout.app', [
    "title" => "Dashboard",
    "breadcrumbs" => [
    [
        'title' => 'Dashboard',
        'url' => null,
    ]]
 ])

@section('content')
    {{-- Admin Statistics Cards --}}
    @if(isset($statistics))
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Teachers</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="{{ $statistics['teachers'] }}">{{ $statistics['teachers'] }}</span>
                                </h4>
                                <a href="{{ route('admin.teachers.index') }}" class="text-decoration-underline">View all teachers</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="mdi mdi-account-tie text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Students</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="{{ $statistics['students'] }}">{{ $statistics['students'] }}</span>
                                </h4>
                                @can('student.view')
                                    <a href="{{ route('teacher.students.index') }}" class="text-decoration-underline">View all students</a>
                                @else
                                    <span class="text-muted">Students Management</span>
                                @endcan
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <i class="mdi mdi-account-school text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Parents</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="{{ $statistics['parents'] }}">{{ $statistics['parents'] }}</span>
                                </h4>
                                @can('parent.view')
                                    <a href="{{ route('teacher.parents.index') }}" class="text-decoration-underline">View all parents</a>
                                @else
                                    <span class="text-muted">Parents Management</span>
                                @endcan
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                    <i class="mdi mdi-account-group text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Announcements</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="{{ $statistics['announcements'] }}">{{ $statistics['announcements'] }}</span>
                                </h4>
                                @can('announcement.view')
                                    <a href="{{ route('admin.announcements.index') }}" class="text-decoration-underline">View all announcements</a>
                                @else
                                    <span class="text-muted">Announcements</span>
                                @endcan
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="mdi mdi-bullhorn text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Recent Announcements --}}
    @if(isset($announcements) && $announcements->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Announcements</h4>
                        @if(isset($statistics))
                            @can('announcement.view')
                                <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
                            @endcan
                        @endif
                    </div>
                    <div class="card-body">
                        @foreach($announcements as $announcement)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                    <h5 class="mb-0">{{ $announcement->title }}</h5>
                                    <small class="text-muted">{{ $announcement->created_at->format('d M, Y h:i A') }}</small>
                                </div>
                                <p class="text-muted mb-2">{{ $announcement->body }}</p>
                                <small class="text-muted">Posted by: {{ $announcement->creator->name ?? 'System' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection