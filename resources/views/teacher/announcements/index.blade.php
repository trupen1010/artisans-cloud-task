@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Announcements',
    'breadcrumbs' => [
        ['title' => 'Management', 'url' => null],
        ['title' => 'Announcements', 'url' => route('teacher.announcements.index')],
    ],
])

@push('style')
    <link href="{{ public_assets('css/datatables.min.css', true) }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="card-title mb-0 flex-grow-1"></div>
                <div class="d-flex flex-wrap gap-2">
                    @can('announcement.add')
                        <a class="btn btn-primary btn-label waves-effect waves-light"
                           href="{{ route('teacher.announcements.create') }}">
                            <i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i>New Announcement
                        </a>
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
                                <th>Body</th>
                                <th>Target</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ public_assets('js/datatables.min.js', true) }}"></script>
    <script>
        $(document).ready(function () {
            const datatable = dynamicDataTable({
                table: "#datatable",
                ajax: { url: "{{ route('teacher.announcements.datatable') }}", type: "POST" },
                columns: [
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'short_body', orderable: false },
                    { data: 'target_badge', orderable: false },
                    { data: 'created_at' },
                    { data: 'action', orderable: false, searchable: false },
                ],
            });

            $(document).on('click', '.delete_btn', function (evt) {
                evt.preventDefault();
                evt.stopImmediatePropagation();
                let url = '{{ route("teacher.announcements.destroy", ":id") }}'
                    .replace(':id', $(this).attr('data-id'));

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