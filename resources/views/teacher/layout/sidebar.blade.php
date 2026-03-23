<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('teacher.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm"><img src="{{ public_assets('images/bkp-favicon.png', true) }}" alt="" height="22"></span>
            <span class="logo-lg">
                <img src="{{ public_assets('images/logo.png', true) }}" alt="" height="50">
            </span>
        </a>
        <a href="{{ route('teacher.dashboard') }}" class="logo logo-light">
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
                <li class="nav-item">
                    <a href="{{ route('teacher.dashboard') }}" class="nav-link menu-link {{ Route::is('teacher.dashboard') ? 'active' : null }}">
                        <i class="mdi mdi-speedometer fs-20"></i><span>Dashboard</span>
                    </a>
                </li>
                @can('student.view')
                    <li class="nav-item"><a href="{{ route('teacher.students.index') }}" class="nav-link {{ Route::is('teacher.students.*') ? 'active' : null }}">Students</a></li>
                @endcan
                @can('parent.view')
                    <li class="nav-item"><a href="{{ route('teacher.parents.index') }}" class="nav-link {{ Route::is('teacher.parents.*') ? 'active' : null }}">Parents</a></li>
                @endcan
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
