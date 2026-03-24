@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Create Student',
    'breadcrumbs' => [[
        'title' => 'Management',
        'url' => null,
    ],
    [
        'title' => 'Students',
        'url' => route('teacher.students.index'),
    ],
    [
        'title' => 'Create',
        'url' => route('teacher.students.create'),
    ]],
])

@section('content')
    <form action="{{ route('teacher.students.store') }}" method="post">
        @csrf
        {{ method_field('post') }}
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Create Student</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" />
                                        <label for="name">Student Name <span class="text-danger">*</span></label>
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
                                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone') }}" />
                                        <label for="phone">Phone Number</label>
                                        <b class="text-danger">{{ $errors->first('phone') }}</b>
                                    </div>
                                </div>

                                <x-forms.dropdown
                                    name="parent_id"
                                    label="Parent"
                                    :options="collect($parents)->pluck('name', 'id')->toArray()"
                                    placeholder="Select Parent (Optional)"
                                />

                                <x-forms.dropdown
                                    name="status"
                                    label="Status"
                                    :options="['active' => 'Active', 'inactive' => 'Inactive']"
                                    :required="true"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        <a href="{{ route('teacher.students.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
