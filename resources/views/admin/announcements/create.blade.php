@extends('admin.layout.app', [
    "title" => "Create Announcement",
    "breadcrumbs" => [[
        "title" => "Management",
        "url" => null
    ],
    [
        'title' => 'Announcements',
        'url' => route('admin.announcements.index')
    ],
    [
        'title' => 'Create',
        'url' => route('admin.announcements.create')
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
<form action="{{ route('admin.announcements.store') }}" method="post">
    @csrf
    {{ method_field('post') }}
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Create Announcement</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="form-floating">
                                    <input name="title" type="text" class="form-control" id="title" placeholder="Enter Title" value="{{ old('title') }}" />
                                    <label for="title">Announcement Title <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('title') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-floating">
                                    <textarea name="body" class="form-control" id="body" placeholder="Enter Description" style="height: 150px">{{ old('body') }}</textarea>
                                    <label for="body">Description <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('body') }}</b>
                                </div>
                            </div>

                            <input type="hidden" name="target" value="teachers" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    <a href="{{ route('admin.announcements.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
