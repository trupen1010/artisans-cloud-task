<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="light" data-theme="material" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-topbar="light" data-sidebar-visibility="show"
    data-layout-style="default" data-bs-theme="light" data-layout-width="fluid" data-layout-position="fixed"
    oncontextmenu="return {{ app()->isProduction() ? 'false' : 'true' }}">

<head>
    <title>{{ @$title ?? '' }} | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="theme-color" content="#a3a6b7" />

    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ public_assets('images/cygner-favicon.png', true) }}"> --}}
    <link rel="shortcut icon" href="{{ public_assets('images/favicon.png', true) }}">
    <!-- jsvectormap css -->
    <link href="{{ public_assets('libs/jsvectormap/css/jsvectormap.min.css', true) }}" rel="stylesheet"
        type="text/css" />
    <!--Swiper slider css-->
    <link href="{{ public_assets('libs/swiper/swiper-bundle.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ public_assets('css/bootstrap.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ public_assets('css/icons.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- ToastiFy css -->
    <link href="{{ public_assets('css/toastify.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- Sweetalert2 css-->
    <link href="{{ public_assets('libs/sweetalert2/sweetalert2.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- Select2 css -->
    <link href="{{ public_assets('css/select2.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ public_assets('css/app.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ public_assets('css/custom.min.css', true) }}" rel="stylesheet" type="text/css" />

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">

    @stack('style')
</head>

<body>

    {{-- Start Loader --}}
    <div class="custom_loading" style="display: none;cursor: wait;">
        <div class="spinner spinner-border mdi-48px text-white text-opacity-75" role="status"><i class="sr-only"></i>
        </div>
    </div>
    {{-- End Loader --}}

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm"><img src="{{ public_assets('images/logo-sm.png', true) }}"
                                        alt="" height="22"></span>
                                <span class="logo-lg"><img src="{{ public_assets('images/logo-dark.png', true) }}"
                                        alt="" height="17"></span>
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                                <span class="logo-sm"><img src="{{ public_assets('images/logo-sm.png', true) }}"
                                        alt="" height="22"></span>
                                <span class="logo-lg"><img src="{{ public_assets('images/logo.png', true) }}"
                                        alt="" height="17"></span>
                            </a>
                        </div>
                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <label class="hamburger-icon p-0 m-0">
                                <span></span>
                                <span></span>
                                <span></span>
                            </label>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- Fullscreen --}}
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>
                        {{-- Profile --}}
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user"
                                        src="{{ public_assets('images/users/avatar-1.jpg', true) }}"
                                        alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">Trupen</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Admin</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome Anna!</h6>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Profile</span></a>
                                {{-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ? Sidebar ? --}}
        @include('admin.layout.sidebar')
        {{-- ? Sidebar ? --}}

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="page-title-box d-flex justify-content-between align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                                    class="ri-home-5-fill"></i></a></li>
                                        @if (isset($breadcrumbs) && is_array($breadcrumbs))
                                            @foreach ($breadcrumbs as $breadcrumb)
                                                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"
                                                    aria-current="{{ $loop->last ? 'page' : '' }}">
                                                    @if (!$loop->last)
                                                        <a
                                                            href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                                    @else
                                                        {{ $breadcrumb['title'] }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="breadcrumb-item active" aria-current="page">
                                                {{ $title }}</li>
                                        @endif
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 p-0" id="content_div">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script type="text/javascript">
        const APP_URL = '{{ url('/') }}'
    </script>
    <!-- JQuery -->
    <script type="text/javascript" src="{{ public_assets('js/jquery.min.js', true) }}"></script>
    <!-- Layout config Js -->
    <script type="text/javascript" src="{{ public_assets('js/layout.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/bootstrap/js/bootstrap.bundle.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/simplebar/simplebar.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/node-waves/waves.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/feather-icons/feather.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/pages/plugins/lord-icon-2.1.0.js', true) }}"></script>

    <script type="text/javascript" src="{{ public_assets('js/toastify.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/flatpickr/flatpickr.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/libs/choices/choices.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/sweetalert2/sweetalert2.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/select2.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/select2-searchInputPlaceholder.min.js', true) }}"></script>

    <!-- App js -->
    <script type="text/javascript" src="{{ public_assets('js/app.js', true) }}"></script>

    @include('admin.layout.notification')

    <script type="text/javascript">
        $(document).ready(function() {
            hide_loader();
        });
    </script>
    
    @stack('script')
</body>

</html>
