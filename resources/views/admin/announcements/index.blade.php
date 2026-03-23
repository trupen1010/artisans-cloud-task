@extends('admin.layout.app', [
    "title" => "Announcements",
    "breadcrumbs" => [[
        "title" => "Management",
        "url" => null
    ],
    [
        'title' => 'Announcements',
        'url' => route('admin.announcements.index')
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
                            @can('announcement.add')
                                <a class="btn btn-primary btn-label waves-effect waves-light" href="{{ route('admin.announcements.create') }}"><i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i>Add New</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Posted By</th>
                                        <th>Target</th>
                                        <th>Date</th>
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
    <script type="text/javascript" src="{{public_assets('js/datatables.min.js', true)}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            const datatable = dynamicDataTable({
                table: "#datatable",
                ajax: {
                    url: "{{ route('admin.announcements.datatable') }}",
                    type: "POST"
                },
                columns: [
                    {data: 'id'},
                    {data: 'title'},
                    {data: 'short_body', orderable: false},
                    {data: 'creator_name'},
                    {data: 'target_badge', orderable: false},
                    {data: 'created_at'},
                    {data: 'action', orderable: false, searchable: false}
                ],
            });

            $(document).on('click', '.delete_btn', function (evt) {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                let delete_id = $(this).attr('data-id'),
                    url = '{{ route("admin.announcements.destroy", ":id") }}';
                    url = url.replace(':id', delete_id);

                showConfirmationDialog({
                    title: "Are you sure?",
                    text: "Do you want to delete this announcement?",
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
        });
    </script>
@endpush
