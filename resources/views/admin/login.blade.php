<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Login | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="theme-color" content="#a3a6b7" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ public_assets('images/favicon.png', true) }}" />

    <!-- Bootstrap Css -->
    <link href="{{ public_assets('css/bootstrap.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ public_assets('css/icons.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ public_assets('css/app.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- ToastiFy css -->
    <link href="{{ public_assets('css/toastify.min.css', true) }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ public_assets('css/custom.min.css', true) }}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .auth-one-bg .bg-overlay {
            background: -webkit-gradient(linear, left top, right top, from(#41319c), to(#4b38b3)) !important;
            background: linear-gradient(to right, #41319c, #4b38b3) !important;
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="javascript:void(0)" class="d-inline-block auth-logo">
                                    <img src="/assets/admin/images/logo.png" width="100" height="100"  alt="Logo">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary fw-bold">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to <strong class="fw-bolder">{{ config('app.name') }}</strong></p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="" method="post">
                                        {{ csrf_field() }}
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Username</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                            <b class="text-danger">{{ $errors->first('email') }}</b>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" value="{{ old('password') }}">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon" type="button" id="password-addon">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                                <b class="text-danger">{{ $errors->first('password') }}</b>
                                                @if (isset($error) && !empty($error))
                                                    <b class="text-danger">{{ session('message') }}</b>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="{{ public_assets('libs/bootstrap/js/bootstrap.bundle.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/simplebar/simplebar.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/node-waves/waves.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('libs/feather-icons/feather.min.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/pages/plugins/lord-icon-2.1.0.js', true) }}"></script>
    <script type="text/javascript" src="{{ public_assets('js/toastify.min.js', true) }}"></script>
    <!-- particles js -->
    <script type="text/javascript" src="{{ public_assets('libs/particles.js/particles.js', true) }}"></script>
    <!-- particles app js -->
    <script type="text/javascript" src="{{ public_assets('js/pages/particles.app.js', true) }}"></script>
    <!-- password-addon init -->
    <script type="text/javascript" src="{{ public_assets('js/pages/password-addon.init.js', true) }}"></script>

    @include('admin.layout.notification')
</body>

</html>