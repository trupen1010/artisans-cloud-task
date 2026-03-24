@extends('admin.layout.app', [
    'layoutPrefix' => 'teacher',
    'title' => 'Edit Announcement',
    'breadcrumbs' => [
        ['title' => 'Management', 'url' => null],
        ['title' => 'Announcements', 'url' => route('teacher.announcements.index')],
        ['title' => 'Edit', 'url' => route('teacher.announcements.edit', $announcement->id)],
    ],
])

@section('content')
<form action="{{ route('teacher.announcements.update', $announcement->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Announcement</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input name="title" type="text" class="form-control" id="title"
                                    placeholder="Title" value="{{ old('title', $announcement->title) }}" />
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <b class="text-danger">{{ $errors->first('title') }}</b>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <select name="target" class="form-select" id="target">
                                    <option value="">Select Target</option>
                                    <option value="students" {{ old('target', $announcement->target) === 'students' ? 'selected' : '' }}>Students Only</option>
                                    <option value="parents"  {{ old('target', $announcement->target) === 'parents'  ? 'selected' : '' }}>Parents Only</option>
                                    <option value="both"     {{ old('target', $announcement->target) === 'both'     ? 'selected' : '' }}>Both (Students & Parents)</option>
                                </select>
                                <label for="target">Send To <span class="text-danger">*</span></label>
                                <b class="text-danger">{{ $errors->first('target') }}</b>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-floating">
                                <textarea name="body" class="form-control" id="body"
                                    placeholder="Body" style="height:160px">{{ old('body', $announcement->body) }}</textarea>
                                <label for="body">Message Body <span class="text-danger">*</span></label>
                                <b class="text-danger">{{ $errors->first('body') }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-end mt-2">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update Announcement</button>
                <a href="{{ route('teacher.announcements.index') }}" class="btn btn-link link-danger fw-semibold">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection