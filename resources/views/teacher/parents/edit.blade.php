@extends('teacher.layout.app', [
    'title' => 'Edit Parent',
    'breadcrumbs' => [[
        'title' => 'Management',
        'url' => null,
    ],
    [
        'title' => 'Parents',
        'url' => route('teacher.parents.index'),
    ],
    [
        'title' => 'Edit',
        'url' => route('teacher.parents.edit', $parent->id),
    ]],
])

@section('content')
    <form action="{{ route('teacher.parents.update', $parent->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Edit Parent</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name', $parent->name) }}" />
                                        <label for="name">Parent Name <span class="text-danger">*</span></label>
                                        <b class="text-danger">{{ $errors->first('name') }}</b>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email', $parent->email) }}" />
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <b class="text-danger">{{ $errors->first('email') }}</b>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone', $parent->phone) }}" />
                                        <label for="phone">Phone Number</label>
                                        <b class="text-danger">{{ $errors->first('phone') }}</b>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <select name="status" class="form-select" id="status">
                                            <option value="active" {{ old('status', $parent->status) === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $parent->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <b class="text-danger">{{ $errors->first('status') }}</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                        <a href="{{ route('teacher.parents.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
