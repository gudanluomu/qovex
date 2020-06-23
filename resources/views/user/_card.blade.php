<div class="card">
    <div class="card-body">
        <h4 class="card-title">员工列表</h4>
        <p class="card-title-desc">管理团队的所有员工</p>
        {{--搜索--}}
        @component('form-components.form-search')
            @slot('groups')
                <div class="col-md-3 col-sm-12 mb-2">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">关键字:</div>
                        </div>
                        <input type="text" class="form-control" placeholder="名称/邮箱" name="name"
                               value="{{ request('name') }}">
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 mb-2">
                    <div class="input-group mb-2" style="flex-wrap:nowrap">
                        <div class="input-group-prepend">
                            <div class="input-group-text">身份:</div>
                        </div>
                        <select name="department_type" class="select2" data-minimum-results-for-search="Infinity">
                            <option value="">所有身份</option>
                            @foreach($userModel->departmentTypeArr as $k=>$v)
                                <option value="{{ $k }}"
                                    {{ $k == request('department_type') ? 'selected' : '' }}>
                                    {{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endslot
        @endcomponent
        {{--操作按钮--}}
        <div class="btn-group">
            <a class="btn btn-primary" href="{{ route('user.create') }}">添加员工</a>
        </div>
    </div>
    {{--表格--}}
    @component('table-components.table-responsive')
        @slot('head')
            <tr>
                <th>#</th>
                <th>名称</th>
                <th>部门</th>
                <th>身份</th>
                <th>职位</th>
                <th>操作</th>
            </tr>
        @endslot
        @slot('body')
            @foreach($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->department->name }}</td>
                    <td>{{ $user->department_type_desc }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge badge-danger" data-toggle="popover"
                                  data-content-id="#perms_content_{{$role->id}}"
                                  data-trigger="hover" data-title="权限详情">{{ $role->name }}</span>

                            <div id="perms_content_{{$role->id}}" class="d-none">
                                @foreach($role->permissions as $permission)
                                    <span class="badge badge-pill badge-success">{{ $permission->cname }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    </td>
                    <td>
                        <a class="font-size-18" delete data-toggle="tooltip" title="删除" href="">
                            <i class="mdi mdi-delete-off-outline"></i></a>
                        <form class="d-none" method="post"
                              action="{{ route('user.destroy',$user) }}">@method('DELETE')@csrf</form>

                        <a class="font-size-18" data-toggle="tooltip" title="编辑"
                           href="{{ route('user.edit',$user) }}"><i
                                class="mdi mdi-file-document-edit-outline"></i></a>

                    </td>
                </tr>
            @endforeach
        @endslot
    @endcomponent
    {{--分页--}}
    @include('paginate-components.paginate',['models'=>$users])
</div>
