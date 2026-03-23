@extends('admin.layout.app', [
    "title" => "Create Teacher",
    "breadcrumbs" => [[
        "title" => "Management",
        "url" => null
    ],
    [
        'title' => 'Teachers',
        'url' => route('admin.teachers.index')
    ],
    [
        'title' => 'Create',
        'url' => route('admin.teachers.create')
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
<form action="{{ route('admin.teachers.store') }}" method="post">
    @csrf
    {{ method_field('post') }}
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Create Teacher</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" />
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('name') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email') }}" />
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('email') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" />
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('password') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" />
                                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('password_confirmation') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone') }}" />
                                    <label for="phone">Phone Number</label>
                                    <b class="text-danger">{{ $errors->first('phone') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select name="status" class="form-select" id="status">
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('status') }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    <a href="{{ route('admin.teachers.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
