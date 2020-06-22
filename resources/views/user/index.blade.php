@extends('layouts.master')

@section('title') 员工管理 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 员工管理  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
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
            <div class="user-bar">
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
                                <th>职位</th>
                                <th>操作</th>
                            </tr>
                        @endslot
                        @slot('body')
                            @foreach($users as $user)
                                <tr>
                                    <th>{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-danger">{{ $role->name }}</span>
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
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    @include('user.department._create')
    @include('user.department._update')
    @include('user.department._delete')
@endsection

@section('script')
    <script !src="">
        $(document).ready(function () {
            //修改
            $('#departmentUpdate').on('show.bs.modal', function (event) {
                var modal = $(this);
                var id = $(event.relatedTarget).data('id');
                var form = modal.find('form');
                var url = '/department/' + id;

                form.attr('action', url);

                $.ajax({
                    url: url,
                    success: function (response) {
                        form.find('[name="name"]').val(response.data.name);
                        form.find('[name="parent_id"]').val(response.data.parent_id).trigger('change');
                    }
                });
            });
            //删除
            $('#departmentDelete').on('show.bs.modal', function (event) {
                var id = $(event.relatedTarget).data('id');
                var url = '/department/' + id;

                $(this).find('form').attr('action', url);
            })
        })
    </script>
@endsection

