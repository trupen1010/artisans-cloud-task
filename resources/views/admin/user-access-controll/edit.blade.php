@extends('admin.layout.app', [
    "title" => "User Access Control Edit",
    "breadcrumbs" => [[
        "title" => "Settings",
        "url" => null
    ],
    [
        'title' => 'User Access Control Edit',
        'url' => route('admin.user.access.control.edit', $role->id)
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
        .form-floating.input-group>.form-control {
            background-color: #eff2f7 !important;
        }
    </style>
@endpush

@section('content')

<form action="{{ route('admin.user.access.control.update', $role->id) }}" method="post">
    @csrf
    {{ method_field('PATCH') }} {{-- Use PATCH or PUT for update --}}
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1 fw-bold">Edit Role & Permissions</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="form-floating">
                                <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name', $role->name) }}" />
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
                            // Check if all permissions in the module are selected
                            $isModuleChecked = count($permissions) === count(array_intersect($permissionIds, array_keys($permissions)));
                        @endphp
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1 fw-bold">{{ $module }}</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch">
                                            {{-- Pre-check the "Select All" checkbox if all permissions are already selected --}}
                                            <input type="checkbox" class="form-check-input module_wise_select_all"
                                                @if($isModuleChecked) checked @endif />
                                            <label class="form-check-label">All</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row ">
                                            @foreach($permissions as $permissionId => $permission)
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 permission_div">
                                                    <div>
                                                        <div class="form-check form-switch mb-3">
                                                            {{-- Pre-check the checkboxes if the permission is already assigned to the role --}}
                                                            <input name="permission[]" class="form-check-input single-permission" type="checkbox" role="switch" id="permission-{{ $permissionId }}" value="{{ $permissionId }}" @checked(in_array($permissionId, old('permission', $permissionIds)))>
                                                            <label class="form-check-label" for="permission-{{ $permissionId }}">{{ $permission }}</label>
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
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                    <a href="{{ route('admin.user.access.control.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("change", ".module_wise_select_all", function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                evt.stopImmediatePropagation();
                module_wise_checkbox_action($(this));
            });

            $(document).on("change", ".single-permission", function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                evt.stopImmediatePropagation();
                single_checkbox_action($(this));
            });

            function module_wise_checkbox_action(check_box) {
                const modulePermissions = check_box.closest('.card').find('.single-permission');

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

                moduleCard.find('.module_wise_select_all').prop('checked', allModulePermissionsChecked);
                updateGlobalSelectAll();
            }

            function updateGlobalSelectAll() {
                const allPermissions = $('.single-permission');
                const allChecked = allPermissions.length === allPermissions.filter(':checked').length;
                const selectAllPermission = $(".select_all_permission");

                if (allChecked) {
                    selectAllPermission.prop({'checked': true, 'indeterminate': false});
                } else if (allPermissions.filter(':checked').length > 0) {
                    selectAllPermission.prop('indeterminate', true).prop('checked', false);
                } else {
                    selectAllPermission.prop({'checked': false, 'indeterminate': false});
                }
            }

            // Initial check to set the module-wise select all based on loaded data
            $(".module_wise_select_all").each(function() {
                const modulePermissions = $(this).closest('.card').find('.single-permission');
                const allModulePermissionsChecked = modulePermissions.length === modulePermissions.filter(':checked').length;
                $(this).prop('checked', allModulePermissionsChecked);
            });
        });
    </script>
@endpush
