@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Create Announcement',
    'breadcrumbs' => [
        ['title' => 'Management', 'url' => null],
        ['title' => 'Announcements', 'url' => route('teacher.announcements.index')],
        ['title' => 'Create', 'url' => route('teacher.announcements.create')],
    ],
])

@section('content')
<form action="{{ route('teacher.announcements.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Create Announcement</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input name="title" type="text" class="form-control" id="title"
                                    placeholder="Title" value="{{ old('title') }}" />
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <b class="text-danger">{{ $errors->first('title') }}</b>
                            </div>
                        </div>

                        <x-forms.dropdown
                            name="target"
                            label="Send To"
                            :options="[
                                'students' => 'Students Only',
                                'parents' => 'Parents Only',
                                'both' => 'Both (Students & Parents)'
                            ]"
                            placeholder="Select Target"
                            :required="true"
                        />

                        <div class="col-lg-12">
                            <div class="form-floating">
                                <textarea name="body" class="form-control" id="body"
                                    placeholder="Body" style="height:160px">{{ old('body') }}</textarea>
                                <label for="body">Message Body <span class="text-danger">*</span></label>
                                <b class="text-danger">{{ $errors->first('body') }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-end mt-2">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Send Announcement</button>
                <a href="{{ route('teacher.announcements.index') }}" class="btn btn-link link-danger fw-semibold">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection