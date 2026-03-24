@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Edit Student',
    'breadcrumbs' => [[
        'title' => 'Management',
        'url' => null,
    ],
    [
        'title' => 'Students',
        'url' => route('teacher.students.index'),
    ],
    [
        'title' => 'Edit',
        'url' => route('teacher.students.edit', $student->id),
    ]],
])

@section('content')
    <form action="{{ route('teacher.students.update', $student->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Edit Student</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name', $student->name) }}" />
                                        <label for="name">Student Name <span class="text-danger">*</span></label>
                                        <b class="text-danger">{{ $errors->first('name') }}</b>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email', $student->email) }}" />
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <b class="text-danger">{{ $errors->first('email') }}</b>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone', $student->phone) }}" />
                                        <label for="phone">Phone Number</label>
                                        <b class="text-danger">{{ $errors->first('phone') }}</b>
                                    </div>
                                </div>

                                <x-forms.dropdown
                                    name="parent_id"
                                    label="Parent"
                                    :options="collect($parents)->pluck('name', 'id')->toArray()"
                                    :value="$student->parent_id"
                                    placeholder="Select Parent (Optional)"
                                />

                                <x-forms.dropdown
                                    name="status"
                                    label="Status"
                                    :options="['active' => 'Active', 'inactive' => 'Inactive']"
                                    :value="$student->status"
                                    :required="true"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                        <a href="{{ route('teacher.students.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
