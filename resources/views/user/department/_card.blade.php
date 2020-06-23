<div class="department-bar card">
    <button type="button" class="btn btn-danger btn-block waves-effect waves-light" data-toggle="modal"
            data-target="#departmentCreate">
        添加部门
    </button>

    <h6 class="mt-4">部门管理</h6>

    <div class="mail-list mt-1">
        @foreach($departments as $department)
            <div>
                <button class="float-right btn btn-link" data-toggle="popover"
                        data-content-id="#popover_content_{{$department->id}}" data-trigger="focus"
                        style="color: #969aa5">
                    <i class="mdi mdi-arrow-right-drop-circle "></i>
                </button>
                <div class="d-none" id="popover_content_{{$department->id}}">
                    <a class="dropdown-item" data-toggle="modal" data-target="#departmentDelete"
                       data-id="{{ $department->id }}">
                        <i class="mdi mdi-delete-off-outline"></i>
                        删除
                    </a>

                    <a class="dropdown-item" data-toggle="modal" data-target="#departmentUpdate"
                       data-id="{{ $department->id }}">
                        <i class="mdi mdi-file-document-edit-outline"></i>
                        修改
                    </a>

                </div>
                <a href="{{ route('user.index',['department_id'=>$department->id]+request()->all()) }}"
                   class="{{ request('department_id') == $department->id ? 'active' :'' }}">
                    <span style="margin-left: {{$department->depth*20}}px">{{ $department->name }}</span>
                </a>

            </div>
        @endforeach
    </div>
</div>
