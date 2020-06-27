@extends('layouts.master')

@section('title') 联盟管理 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 联盟管理  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">联盟列表</h4>
                    <p class="card-title-desc">管理团队的所有淘宝联盟账号</p>
                    {{--搜索--}}
                    @component('form-components.form-search')
                        @slot('groups')
                            <div class="col-md-3 col-sm-12 mb-2">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">联盟名称:</div>
                                    </div>
                                    <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                                </div>
                            </div>
                        @endslot
                    @endcomponent
                    {{--操作按钮--}}
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('taobao.auth.create') }}">添加联盟</a>
                    </div>
                </div>
                {{--表格--}}
                @component('table-components.table-responsive')
                    @slot('head')
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>ID</th>
                            <th>到期时间</th>
                            <th>操作</th>
                        </tr>
                    @endslot
                    @slot('body')
                        @foreach($auths as $auth)
                            <tr>
                                <th>{{ $auth->id }}</th>
                                <td>{{ $auth->taobao_user_nick }}</td>
                                <td>{{ $auth->taobao_user_id }}</td>
                                <td>
                                    <span
                                        @if($auth->isExpired()) style="color: red;" data-toggle="tooltip"
                                        title="已到期,请重新授权" @endif>{{ $auth->expire_time_str }}</span>
                                </td>
                                <td>
                                    <a class="font-size-18" delete data-toggle="tooltip" title="删除" href="">
                                        <i class="mdi mdi-delete-off-outline"></i></a>
                                    <form class="d-none" method="post"
                                          action="{{ route('taobao.auth.destroy',$auth) }}">@method('DELETE')@csrf</form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                @endcomponent
                {{--分页--}}
                @include('paginate-components.paginate',['models'=>$auths])
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
