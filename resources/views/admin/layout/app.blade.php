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
    @php
        $layoutPrefix = request()->routeIs('teacher.*') ? 'teacher' : 'admin';
    @endphp

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
                            <a href="{{ route($layoutPrefix.'.dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm"><img src="{{ public_assets('images/logo-sm.png', true) }}"
                                        alt="" height="22"></span>
                                <span class="logo-lg"><img src="{{ public_assets('images/logo-dark.png', true) }}"
                                        alt="" height="17"></span>
                            </a>
                            <a href="{{ route($layoutPrefix.'.dashboard') }}" class="logo logo-light">
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
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ? Sidebar ? --}}
        @include($layoutPrefix.'.layout.sidebar')
        {{-- ? Sidebar ? --}}

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="page-title-box d-flex justify-content-between align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route($layoutPrefix.'.dashboard') }}"><i
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

            $('[data-tooltip="tooltip"]').tooltip();

            // Function to create a Cleave instance for an element
            const createCleaveInstance = (element, options) => new Cleave(element, options);

            // Options for date, time, and datetime masks
            const maskOptions = {
                date: {
                    date: true,
                    delimiter: "-",
                    datePattern: ["d", "m", "Y"]
                },
                time: {
                    time: true,
                    timePattern: ["h", "m", "s"]
                },
                datetime: {
                    delimiters: ["-", "-", " ", ":", ":"],
                    blocks: [2, 2, 4, 2, 2, 2],
                    numericOnly: true,
                }
            };

            // Function to apply masks to elements
            const applyMasks = (selector, maskType) => {
                const elements = document.querySelectorAll(selector);
                elements.forEach(element => createCleaveInstance(element, maskOptions[maskType]));
            };

            // Apply masks
            applyMasks(".date-mask", "date");
            applyMasks(".time-mask", "time");
            applyMasks(".datetime-mask", "datetime");

            $('.select2').select2({
                searchInputPlaceholder: 'Type to filter...'
            });
            $('.select2-non-searchable').select2({
                searchInputPlaceholder: 'Type to filter...',
                minimumResultsForSearch: Infinity
            });

            initSelect2Multiple();

            // Dynamic Character count functionality
            $(document).on('input', '.char-count', function(evt) {
                evt.preventDefault();

                const $input = $(this);
                const $countDisplay = $(`.count-display[data-id="${$input.attr('id')}"]`);

                if ($countDisplay.length) {
                    const maxLength = $input.attr('maxLength') || Infinity;
                    const currentLength = $input.val().length;
                    const characterCount = `${currentLength}/${maxLength} characters`;

                    $countDisplay.text(characterCount)
                        .removeClass('text-muted text-danger text-dark')
                        .addClass(currentLength === parseInt(maxLength) ? 'text-danger' : currentLength ===
                        0 ? 'text-muted' : 'text-dark');
                }
            });

        });

        /**
         * Update Select2 Open Z-Index
         */
        function updateSelect2OpenZIndex() {
            const hasOverlay = $('.offcanvas.show, .modal.show').length > 0;
            const zIndex = hasOverlay ? "1055" : "";
            $('.select2-container.select2-container--open, .popup-z-index').css('z-index', zIndex);
        }
        $(document).on('shown.bs.offcanvas shown.bs.modal hidden.bs.offcanvas hidden.bs.modal', function() {
            updateSelect2OpenZIndex();
        });

        /**
         * Initialize Multiple Select2
         */
        function initSelect2Multiple() {
            const elements = $('.select2-multiple');

            const options = {
                dropdownAutoWidth: true,
                multiple: true,
                placeholder: "Type to filter...",
                allowClear: true,
                dropdownParent: $(document.body)
            }

            elements.each(function() {
                const eachElement = $(this);

                // Only destroy if Select2 has been initialized
                if (eachElement.data('select2')) {
                    eachElement.select2('destroy');
                }

                // Initialize Select2
                eachElement.select2(options);
            });
        }

        function initializeSelect2(selector, dropdownParents = null, options = {}) {
            const $elements = $(selector);
            let parentArray = [];

            if (dropdownParents) {
                parentArray = dropdownParents.split(',').map(p => p.trim());
            }

            const defaultOptions = {
                width: '100%',
                placeholder: "Type to filter...",
                allowClear: true,
                templateResult: data => data.id ? $('<span>' + data.text + '</span>') : data.text,
                templateSelection: data => data.id ? $('<span>' + data.text + '</span>') : data.text,
            };

            $elements.each(function() {
                const $select = $(this);
                const isFloating = $select.closest('.form-floating').length > 0;

                // Destroy old Select2
                if ($select.data('select2')) {
                    $select.select2('destroy');
                }

                // Find the closest parent (if exists)
                const matchedParent = parentArray.find(parentSel => $select.closest(parentSel).length);
                const dropdownParent = matchedParent ? $select.closest(matchedParent) : null;

                $select.select2($.extend({}, defaultOptions, options, {
                    dropdownParent: dropdownParent || null
                }));

                if (isFloating) {
                    $select.on('select2:open', () =>
                        $select.closest('.form-floating').find('label').css('opacity', '1')
                    ).on('select2:close', () =>
                        $select.closest('.form-floating').find('label').css('opacity', '1')
                    );
                }
            });
        }

        $(document).on('shown.bs.modal', function(e) {
            const $modal = $(e.target);
            const modalId = $modal.attr('id');

            // Wait for modal to be fully rendered
            setTimeout(function() {
                $modal.find('select.select2').each(function() {
                    const $select = $(this);
                    const wireModel = $select.attr('wire:model');
                    const isFloating = $select.closest('.form-floating').length > 0;
                    // Destroy existing Select2 to ensure clean state
                    if ($select.data('select2')) {
                        $select.select2('destroy');
                    }

                    // Initialize Select2 with proper modal settings
                    $select.select2({
                        searchInputPlaceholder: 'Type to filter...',
                        dropdownParent: $modal,
                        width: '100%',
                        placeholder: $select.find('option:first').text() ||
                            'Select an option',
                        templateResult: data => data.id ? $('<span>' + data.text +
                            '</span>') : data.text,
                        templateSelection: data => data.id ? $('<span>' + data.text +
                            '</span>') : data.text,
                    });

                    // Add Livewire integration
                    if (wireModel) {
                        $select.on('select2:select', function(e) {
                            const value = e.params.data.id;

                            if (typeof $wire !== 'undefined') {
                                $wire.set(wireModel, value);
                            }
                        });

                        $select.on('select2:unselect', function(e) {
                            if (typeof $wire !== 'undefined') {
                                $wire.set(wireModel, null);
                            }
                        });
                    }
                    if (isFloating) {
                        $select.on('select2:open', () =>
                            $select.closest('.form-floating').find('label').css('opacity', '1')
                        ).on('select2:close', () =>
                            $select.closest('.form-floating').find('label').css('opacity', '1')
                        );
                    }
                });

                $modal.find('select.select2-non-searchable').each(function() {
                    const $select = $(this);
                    const wireModel = $select.attr('wire:model');

                    if ($select.data('select2')) {
                        $select.select2('destroy');
                    }

                    $select.select2({
                        searchInputPlaceholder: 'Type to filter...',
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $modal,
                        width: '100%',
                        placeholder: $select.find('option:first').text() ||
                            'Select an option'
                    });

                    if (wireModel) {
                        $select.on('select2:select', function(e) {
                            const value = e.params.data.id;
                            if (typeof $wire !== 'undefined') {
                                $wire.set(wireModel, value);
                            }
                        });
                    }
                });
            }, 100);
        });

        $(document).on('hidden.bs.modal', function(e) {
            const $modal = $(e.target);

            $modal.find('select.select2, select.select2-non-searchable').each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });
        });

        let initialValues = {};

        // Store the initial values on page load
        $('select.select2-init').each(function() {
            initialValues[this.id] = $(this).val();
        });

        // Reset button functionality
        $(document).on("click", ".reset_all_select", function(e) {
            e.preventDefault(); // Prevent default form reset behavior if needed
            $('select.select2-init').each(function() {
                const initialValue = initialValues[this.id] || null;
                $(this).val(initialValue).trigger('change');
            });
        });

        function formatResult(item) {
            if (item.loading) {
                return item.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(item.text);
            return $container;
        }

        function formatSelection(item) {
            return item.text || item.id;
        }

        /**
         * Toggle Select All
         * @param that
         */
        function toggleSelectAllSelect2(that) {
            let item = $(that.parents("span[class*='select2-container']").siblings('select[multiple]'));
            let selectAll = true;

            item.find("option").each(function(k, v) {
                if (!$(v).prop('selected')) {
                    selectAll = false;
                    return false;
                }
            });

            let iconClass = selectAll ? 'mdi mdi-checkbox-multiple-marked' : 'mdi mdi-close-box-multiple';
            $(that.parents('.select2-container').find('.select2-multiple-all i')).attr('class', iconClass);

            item.find("option").prop('selected', !selectAll);
            item.trigger('change');
        }

        /**
         * Dynamic DataTable Call
         */
        function dynamicDataTable({
                                      table,
                                      ajax,
                                      order,
                                      columns,
                                      lengthMenu = [
                                          [10, 25, 50, 75, 100, -1],
                                          [10, 25, 50, 75, 100, 'ALL']
                                      ],
                                      pageLength = 10,
                                  }, __drawCallbackFn, __preDrawCallbackFn, __stateSave = false, ) {
            const datatable = $(table).DataTable({
                stateSave: __stateSave ? true : false,
                processing: true,
                serverSide: true,
                ajax: function(data, callBack) {
                    let appendAjaxData = {};
                    try {
                        if (typeof ajax.data === 'function') {
                            appendAjaxData = ajax.data(data);
                        } else if (typeof ajax.data === 'object') {
                            appendAjaxData = Object.assign({}, ajax.data, data);
                        } else {
                            appendAjaxData = data;
                        }
                    } catch (error) {
                        console.error('Error in ajax.data:', error);
                        callBack({ data: [], recordsTotal: 0, recordsFiltered: 0 });
                        return;
                    }
                    ajaxCall(ajax.url, ajax.type, appendAjaxData)
                        .then(response => {
                            try {
                                callBack(response);
                            } catch (e) {
                                console.error('Error in DataTables callback:', e);
                                callBack({ data: [], recordsTotal: 0, recordsFiltered: 0 });
                            }
                        })
                        .catch(error => {
                            show_notify(error.message, 'fail');
                            callBack({ data: [], recordsTotal: 0, recordsFiltered: 0 });
                        });
                },
                columns,
                autoWidth: true,
                order,
                lengthMenu,
                pageLength,
                colReorder: false,
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {
                        'first': '<span class="mdi mdi-page-first mdi-before"></span>',
                        'previous': '<span class="mdi mdi-chevron-left mdi-before"></span>',
                        'next': '<span class="mdi mdi-chevron-right mdi-before"></span>',
                        'last': '<span class="mdi mdi-page-last mdi-before"></span>',
                    },
                },
                drawCallback: function(data) {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');

                    $('.dt-search input[type=search]').attr('placeholder', 'Type to filter...');
                    $('.dt-length select').css('margin-left', '5px');

                    if (typeof __drawCallbackFn !== "undefined") {
                        __drawCallbackFn(data);
                    }
                },
                preDrawCallback: function(data) {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                    if (typeof __preDrawCallbackFn !== "undefined") {
                        __preDrawCallbackFn(data);
                    }
                },
            });

            return datatable;
        }

        /**
         * Dynamic AJAX Call
         * @param url
         * @param method_type
         * @param post_data
         * @param multipart
         * @param header_data
         * @returns {Promise<unknown>}
         */
        function ajaxCall(url, method_type, post_data, multipart = false, header_data) {
            return new Promise(function(resolve, reject) {

                // Combine static and dynamic headers
                const headers = Object.assign(
                    (header_data || {}), {
                        "X-CSRF-TOKEN": _token
                    }
                );

                // Initialize options object
                const options = {
                    method: method_type,
                    url: url,
                    async: true,
                    headers: headers,
                    data: post_data,
                    contentType: 'application/x-www-form-urlencoded',
                    dataType: 'json',
                    success: resolve,
                    error: function(xhr) {
                        let status, message;
                        switch (xhr.status) {
                            case 0:
                                status = 'warning';
                                message = 'Not connect. Verify Network.';
                                break;
                            case 400:
                                status = 'warning';
                                message = 'Bad Request.';
                                break;
                            case 404:
                                status = 'fail';
                                message = 'Requested page not found';
                                break;
                            case 500:
                                status = 'fail';
                                message = 'Internal Server Error.';
                                break;
                            case 419:
                                status = 'fail';
                                message = 'Bad hostname provided.';
                                break;
                            case 'parsererror':
                                status = 'fail';
                                message = 'Request failed.';
                                break;
                            case 'timeout':
                                status = 'warning';
                                message = 'Time out error.';
                                break;
                            case 'abort':
                                status = 'warning';
                                message = 'Request aborted.';
                                break;
                            default:
                                status = 'fail';
                                message = xhr.responseText;
                                break;
                        }
                        reject({
                            status,
                            message,
                            responseJSON: xhr.responseJSON
                        });
                    }
                }

                // Conditionally set content type options
                if (multipart) {
                    options.contentType = false;
                    options.cache = false;
                    options.processData = false;
                } else {
                    options.contentType = 'application/x-www-form-urlencoded';
                }

                $.ajax(options);
            });
        }

        /**
         * Dynamic Confirmation Alert Dialog
         * @param __objects
         * @param callBack
         * @returns {Promise<*>}
         */
        async function showConfirmationDialog(__objects, callBack) {
            return await Swal.fire({
                title: __objects.title,
                text: __objects.text,
                icon: __objects.icon,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                buttonsStyling: true,
                reverseButtons: true
            }).then(function(isConfirm) {
                if (isConfirm.value) {
                    callBack();
                }
            });
        }
    </script>

    @stack('script')
</body>

</html>
