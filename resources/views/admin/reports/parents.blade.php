@extends('admin.layout.app', [
    'title' => 'Parent Reports',
    'breadcrumbs' => [[
        'title' => 'Reports',
        'url' => null,
    ],
    [
        'title' => 'Parents',
        'url' => route('admin.reports.parents'),
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
                        <div class="card-title mb-0 flex-grow-1">All Parents</div>
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
                                        <th>Teacher</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Status</th>
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
            dynamicDataTable({
                table: "#datatable",
                ajax: {
                    url: "{{ route('admin.reports.parents.datatable') }}",
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
                        data: 'teacher_name'
                    },
                    {
                        data: 'created_by_name',
                        orderable: false
                    },
                    {
                        data: 'updated_by_name',
                        orderable: false
                    },
                    {
                        data: 'status_badge',
                        orderable: false
                    }
                ],
                pageLength: -1,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });
        });
    </script>
@endpush
