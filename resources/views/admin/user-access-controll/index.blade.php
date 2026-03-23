@extends('admin.layout.app', [
    "title" => "User Access Controll",
    "breadcrumbs" => [[
        "title" => "Settings",
        "url" => null
    ],
    [
        'title' => 'User Access Controll',
        'url' => route('admin.user.access.control.index')
    ]]
 ])

@push('style')
    <link href="{{ public_assets('css/datatables.min.css', true) }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="card-title mb-0 flex-grow-1"></div>
                        <div class="d-flex flex-wrap gap-2">
                            @can('rolePermission.add')
                                <a class="btn btn-primary btn-label waves-effect waves-light" href="{{ route('admin.user.access.control.create') }}"><i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i>Add New</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript" src="{{public_assets('libs/cleave.js/cleave.min.js', true)}}"></script>
    <script type="text/javascript" src="{{public_assets('js/datatables.min.js', true)}}"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            const datatable = dynamicDataTable({
                table: "#datatable",
                ajax: {
                    url: "{{ route('admin.user.access.control.datatable') }}",
                    type: "POST"
                },
                columns: [
                    {data: 'name'},
                    {data: 'action', orderable: false, searchable: false}
                ],
            });

            $(document).on('click', '.delete_btn', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                evt.stopImmediatePropagation();

                let delete_id = $(this).attr('data-id'),
                    url = '{{ route("admin.user.access.control.destroy", ":id") }}';
                    url = url.replace(':id', delete_id);

                showConfirmationDialog({
                    title: "Are you sure?",
                    text: "Do you want to delete this record?",
                    icon: "warning"
                }, function () {
                    show_loader();
                    ajaxCall(url, 'DELETE').then(function (response) {
                        show_notify(response.message, response.status);
                        hide_loader();
                        datatable.draw();
                    }).catch(function (error) {
                        show_notify(error.message, 'fail');
                        hide_loader();
                    });
                });
            });

            $('#example tbody tr').each(function() {
                $(this).find('td:not(:nth-last-child(-n+1))').css('cursor', 'pointer');
            });

            $('#example tbody tr').click(function(e) {
                if (!$(e.target).closest('td:nth-last-child(-n+1)').length) {
                    $('#offcanvasRight').offcanvas('toggle');
                }
            });
        });
    </script>
@endpush
