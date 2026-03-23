<div class="dropdown d-inline-block z-index-up">
    <button type="button" class="btn btn-soft-primary btn-icon dropdown waves-effect waves-light dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-menu-2-line"></i></button>
    <ul class="dropdown-menu dropdown-menu-end">
        @can('parent.edit')
            <li>
                <a href="{{ route('teacher.parents.edit', $parent->id) }}" class="dropdown-item"><i class="ri-pencil-line align-bottom me-2 text-muted"></i> Edit</a>
            </li>
        @endcan
        @can(['parent.edit', 'parent.delete'])
            <li class="dropdown-divider"></li>
        @endcan
        @can('parent.delete')
            <li>
                <a href="javascript:void(0)" class="dropdown-item delete_btn" data-id="{{ $parent->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a>
            </li>
        @endcan
    </ul>
</div>
