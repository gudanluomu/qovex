@extends('layouts.master')

@section('title') 权限管理 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 权限管理  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">权限列表</h4>
                    <p class="card-title-desc">管理团队的所有权限</p>
                    {{--搜索--}}
                    @component('form-components.form-search')
                        @slot('groups')
                            <div class="col-md-3 col-sm-12 mb-2">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">权限名称:</div>
                                    </div>
                                    <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                                </div>
                            </div>
                        @endslot
                    @endcomponent
                    {{--操作按钮--}}
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('role.create') }}">添加权限</a>
                    </div>
                </div>
                {{--表格--}}
                @component('table-components.table-responsive')
                    @slot('head')
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>详情</th>
                            <th>操作</th>
                        </tr>
                    @endslot
                    @slot('body')
                        @foreach($roles as $role)
                            <tr>
                                <th>{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <span class="badge badge-pill badge-success">{{ $permission->cname }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="font-size-18" delete data-toggle="tooltip" title="删除" href="">
                                        <i class="mdi mdi-delete-off-outline"></i></a>
                                    <form class="d-none" method="post"
                                          action="{{ route('role.destroy',$role) }}">@method('DELETE')@csrf</form>

                                    <a class="font-size-18" data-toggle="tooltip" title="编辑"
                                       href="{{ route('role.edit',$role) }}"><i
                                            class="mdi mdi-file-document-edit-outline"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                @endcomponent
                {{--分页--}}
                @include('paginate-components.paginate',['models'=>$roles])
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
