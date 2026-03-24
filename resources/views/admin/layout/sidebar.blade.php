<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    {{-- ? LOGO ? --}}
    <div class="navbar-brand-box">

        <a href="{{ route($layoutPrefix.'.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm"><img src="{{ public_assets('images/bkp-favicon.png', true) }}" alt="" height="22"></span>
            <span class="logo-lg">
                <img src="{{ public_assets('images/logo.png', true) }}" alt="" height="50">
            </span>
        </a>
        <a href="{{ route($layoutPrefix.'.dashboard') }}" class="logo logo-light">
            <span class="logo-sm"><img src="{{ public_assets('images/favicon.png', true) }}" alt="" height="22"></span>
            <span class="logo-lg"><img src="{{ public_assets('images/logo.png', true) }}" alt="" height="50"></span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                {{-- Dashboard - Always visible to authenticated users --}}
                <li class="nav-item">
                    <a href="{{ route($layoutPrefix.'.dashboard') }}" class="nav-link menu-link {{ Route::is($layoutPrefix.'.dashboard') ? 'active' : null }}">
                        <i class="mdi mdi-speedometer fs-20"></i><span>Dashboard</span>
                    </a>
                </li>

                {{-- Admin Only Sections --}}
                @if(auth()->user()->hasRole('admin'))
                    {{-- User Access Control - Admin only --}}
                    @can('rolePermission.view')
                        <li class="nav-item">
                            <a href="{{ route('admin.user.access.control.index') }}" class="nav-link {{ Route::is('admin.user.access.control.*') ? 'active' : null }}">
                                <i class="mdi mdi-shield-account fs-20"></i><span>User Access Control</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Teachers Management - Admin only --}}
                    @can('teacher.view')
                        <li class="nav-item">
                            <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ Route::is('admin.teachers.*') ? 'active' : null }}">
                                <i class="mdi mdi-account-tie fs-20"></i><span>Teachers</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Announcements - Admin only --}}
                    @can('announcement.view')
                        <li class="nav-item">
                            <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ Route::is('admin.announcements.*') ? 'active' : null }}">
                                <i class="mdi mdi-bullhorn fs-20"></i><span>Announcements</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Reports - Admin only --}}
                    @can('report.view')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.students') }}" class="nav-link {{ Route::is('admin.reports.students') ? 'active' : null }}">
                                <i class="mdi mdi-file-chart fs-20"></i><span>Student Reports</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.parents') }}" class="nav-link {{ Route::is('admin.reports.parents') ? 'active' : null }}">
                                <i class="mdi mdi-file-chart fs-20"></i><span>Parent Reports</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.announcements') }}" class="nav-link {{ Route::is('admin.reports.announcements') ? 'active' : null }}">
                                <i class="mdi mdi-file-chart fs-20"></i><span>Announcement Reports</span>
                            </a>
                        </li>
                    @endcan
                @endif

                {{-- Teacher Only Sections --}}
                @if(auth()->user()->hasRole('teacher'))
                    {{-- Students Management - Teachers with student permissions --}}
                    @canany(['student.view', 'student.add'])
                        <li class="nav-item">
                            <a href="{{ auth()->user()->can('student.view') ? route('teacher.students.index') : route('teacher.students.create') }}" class="nav-link {{ Route::is('teacher.students.*') ? 'active' : null }}">
                                <i class="mdi mdi-account-school fs-20"></i><span>Students</span>
                            </a>
                        </li>
                    @endcanany

                    {{-- Parents Management - Teachers with parent permissions --}}
                    @canany(['parent.view', 'parent.add'])
                        <li class="nav-item">
                            <a href="{{ auth()->user()->can('parent.view') ? route('teacher.parents.index') : route('teacher.parents.create') }}" class="nav-link {{ Route::is('teacher.parents.*') ? 'active' : null }}">
                                <i class="mdi mdi-account-group fs-20"></i><span>Parents</span>
                            </a>
                        </li>
                    @endcanany

                    {{-- Announcements Management - Teachers with announcement permissions --}}
                    @canany(['announcement.view', 'announcement.add'])
                        <li class="nav-item">
                            <a href="{{ auth()->user()->can('announcement.view') ? route('teacher.announcements.index') : route('teacher.announcements.create') }}" class="nav-link {{ Route::is('teacher.announcements.*') ? 'active' : null }}">
                                <i class="mdi mdi-bullhorn fs-20"></i><span>Announcements</span>
                            </a>
                        </li>
                    @endcanany
                @endif
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
