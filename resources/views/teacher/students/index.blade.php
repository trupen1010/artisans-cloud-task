@extends('teacher.layout.app', [
    'title' => 'Students',
    'breadcrumbs' => [[
        'title' => 'Management',
        'url' => null,
    ],
    [
        'title' => 'Students',
        'url' => route('teacher.students.index'),
    ]],
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
                            @can('student.add')
                                <a class="btn btn-primary btn-label waves-effect waves-light" href="{{ route('teacher.students.create') }}"><i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i>Add New</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Parent</th>
                                        <th>Status</th>
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
    <script type="text/javascript" src="{{ public_assets('js/datatables.min.js', true) }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            const datatable = dynamicDataTable({
                table: "#datatable",
                ajax: {
                    url: "{{ route('teacher.students.datatable') }}",
                    type: "POST"
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'parent_name',
                        orderable: false
                    },
                    {
                        data: 'status_badge',
                        orderable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $(document).on('click', '.delete_btn', function(evt) {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                let delete_id = $(this).attr('data-id'),
                    url = '{{ route("teacher.students.destroy", ":id") }}';
                url = url.replace(':id', delete_id);

                showConfirmationDialog({
                    title: "Are you sure?",
                    text: "Do you want to delete this student?",
                    icon: "warning"
                }, function() {
                    show_loader();
                    ajaxCall(url, 'DELETE').then(function(response) {
                        show_notify(response.message, response.status);
                        hide_loader();
                        datatable.draw();
                    }).catch(function(error) {
                        show_notify(error.message, 'fail');
                        hide_loader();
                    });
                });
            });
        });
    </script>
@endpush
