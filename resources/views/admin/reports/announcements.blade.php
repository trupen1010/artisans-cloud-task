@extends('admin.layout.app', [
    'title' => 'Announcement Reports',
    'breadcrumbs' => [[
        'title' => 'Reports',
        'url' => null,
    ],
    [
        'title' => 'Announcements',
        'url' => route('admin.reports.announcements'),
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
                        <div class="card-title mb-0 flex-grow-1">Teacher Announcements for Students/Parents</div>
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
                                        <th>Updated By</th>
                                        <th>Target</th>
                                        <th>Date</th>
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
                    url: "{{ route('admin.reports.announcements.datatable') }}",
                    type: "POST"
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'short_body',
                        orderable: false
                    },
                    {
                        data: 'creator_name'
                    },
                    {
                        data: 'updater_name',
                        orderable: false
                    },
                    {
                        data: 'target_badge',
                        orderable: false
                    },
                    {
                        data: 'created_at'
                    }
                ],
                pageLength: -1,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });
        });
    </script>
@endpush
