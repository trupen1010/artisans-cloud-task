@extends('admin.layout.app', [
    "title" => "Edit Teacher",
    "breadcrumbs" => [[
        "title" => "Management",
        "url" => null
    ],
    [
        'title' => 'Teachers',
        'url' => route('admin.teachers.index')
    ],
    [
        'title' => 'Edit',
        'url' => route('admin.teachers.edit', $teacher->id)
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
<form action="{{ route('admin.teachers.update', $teacher->id) }}" method="post">
    @csrf
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Edit Teacher</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name', $teacher->user->name) }}" />
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('name') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email', $teacher->user->email) }}" />
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <b class="text-danger">{{ $errors->first('email') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" />
                                    <label for="password">Password (Leave blank to keep current)</label>
                                    <b class="text-danger">{{ $errors->first('password') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" />
                                    <label for="password_confirmation">Confirm Password</label>
                                    <b class="text-danger">{{ $errors->first('password_confirmation') }}</b>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone', $teacher->phone) }}" />
                                    <label for="phone">Phone Number</label>
                                    <b class="text-danger">{{ $errors->first('phone') }}</b>
                                </div>
                            </div>

                            <x-forms.dropdown
                                name="status"
                                label="Status"
                                :options="['active' => 'Active', 'inactive' => 'Inactive']"
                                :value="$teacher->status"
                                :required="true"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                    <a href="{{ route('admin.teachers.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
