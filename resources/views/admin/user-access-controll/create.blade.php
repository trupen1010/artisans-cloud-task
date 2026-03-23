@extends('admin.layout.app', [
    "title" => "User Access Controll Create",
    "breadcrumbs" => [[
        "title" => "Settings",
        "url" => null
    ],
    [
        'title' => 'User Access Controll Create',
        'url' => route('admin.settings.user.access.control.create')
    ]]
 ])

@push('style')
    <style type="text/css">
        .form-control:focus {
            z-index: unset !important;
        }
        .form-floating>.form-control:not(:placeholder-shown)~label::after {
            background-color: transparent !important;
        }
        .input-group-text {
            padding-left: 2.5rem !important;
        }
        .form-check-input {
            border: 1px solid #482fa0 !important;
        }
        .form-check-input:checked {
            border: 1px solid #a0000e !important;
        }
        .form-floating.input-group>.form-control {
            background-color: #eff2f7 !important;
        }
    </style>
@endpush

@section('content')


<form action="{{ route('admin.settings.user.access.control.store') }}" method="post">
    @csrf
    {{ method_field('post') }}
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Create Role & Permissions</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="form-floating">
                                <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" />
                                <label for="name">Enter Role Name</label>
                                <b class="text-danger">{{ $errors->first('name') }}</b>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                @foreach($permissions as $module => $permissions)
                    @php
                        $module = ucwords(trim(str_replace(array('Controller', "_", "-", " ", " "), " ", $module)));
                    @endphp
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ $module }}</h4>
                                <div class="flex-shrink-0">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input module_wise_select_all" role="switch"/>
                                        <label class="form-check-label">All</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="row ">
                                        @foreach($permissions as $permissionsId => $permission)
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 permission_div">
                                                <div>
                                                    <div class="form-check form-switch mb-3">
                                                        <input name="permission[]" class="form-check-input single-permission" type="checkbox" role="switch" id="permission-{{ $permissionsId }}" value="{{ $permissionsId }}">
                                                        <label class="form-check-label" for="permission-{{ $permissionsId }}">{{ $permission }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <b class="text-danger">{{ $errors->first('permission') }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <div class="col-lg-12 text-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    <a href="{{ route('admin.settings.user.access.control.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            // Module-wise select all
            $(document).on("change", ".module_wise_select_all", function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                evt.stopImmediatePropagation();
                module_wise_checkbox_action($(this));
            });

            // Single permission change action
            $(document).on("change", ".single-permission", function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                evt.stopImmediatePropagation();
                single_checkbox_action($(this));
            });

            function module_wise_checkbox_action(check_box) {
                const modulePermissions = check_box.closest('.card').find('.single-permission');

                // Check/uncheck all permissions within the module
                if (check_box.is(':checked')) {
                    modulePermissions.prop("checked", true);
                } else {
                    modulePermissions.prop("checked", false);
                }

                updateGlobalSelectAll();
            }

            function single_checkbox_action(check_box) {
                const moduleCard = check_box.closest('.card');
                const modulePermissions = moduleCard.find('.single-permission');
                const allModulePermissionsChecked = modulePermissions.length === modulePermissions.filter(':checked').length;

                // Set the module-wise select all checkbox state
                moduleCard.find('.module_wise_select_all').prop('checked', allModulePermissionsChecked);

                updateGlobalSelectAll();
            }

            function updateGlobalSelectAll() {
                const allPermissions = $('.single-permission');
                const allChecked = allPermissions.length === allPermissions.filter(':checked').length;
                const selectAllPermission = $(".select_all_permission");

                // Update the global select all checkbox state
                if (allChecked) {
                    selectAllPermission.prop({'checked': true, 'indeterminate': false});
                } else if (allPermissions.filter(':checked').length > 0) {
                    selectAllPermission.prop('indeterminate', true).prop('checked', false);
                } else {
                    selectAllPermission.prop({'checked': false, 'indeterminate': false});
                }
            }
        });
    </script>
@endpush

