@extends('teacher.layout.app', [
    'title' => 'Create Parent',
    'breadcrumbs' => [[
        'title' => 'Management',
        'url' => null,
    ],
    [
        'title' => 'Parents',
        'url' => route('teacher.parents.index'),
    ],
    [
        'title' => 'Create',
        'url' => route('teacher.parents.create'),
    ]],
])

@section('content')
    <form action="{{ route('teacher.parents.store') }}" method="post">
        @csrf
        {{ method_field('post') }}
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Create Parent</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" />
                                        <label for="name">Parent Name <span class="text-danger">*</span></label>
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
                        <a href="{{ route('teacher.parents.index') }}" type="reset" class="btn btn-link link-danger waves-effect waves-light fw-semibold">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
