@extends('layouts.master')

@section('title') DOU+投放 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') DOU+投放  @endslot
        @slot('li_1') 内容管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">DOU+投放列表</h4>
                    <p class="card-title-desc">查看团队的投放信息列表</p>
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

                </div>
                {{--表格--}}
                @component('table-components.table-responsive')
                    @slot('head')
                        <tr>
                            <th>视频ID</th>
                            <th>视频作者ID</th>
                            <th>付款账号ID</th>
                            <th>状态</th>
                            <th>预计投放次数</th>
                            <th>真实投放次数</th>
                            <th>预计投放金额</th>
                            <th>真实投放次数</th>
                            <th>操作人ID</th>
                        </tr>
                    @endslot
                    @slot('body')
                        @foreach($douplus as $order)
                            <tr>
                                <td>{{ $order->aweme_id }}</td>
                                <td>{{ $order->author_user_id }}</td>
                                <td>{{ $order->pay_user_id }}</td>
                                <td>{{ $order->is_run }}</td>
                                <td>{{ $order->budget_num }}</td>
                                <td>{{ $order->real_num }}</td>
                                <td>{{ $order->budget_amount }}</td>
                                <td>{{ $order->real_amount }}</td>
                                <td>{{ $order->creator_id }}</td>
                            </tr>
                        @endforeach
                    @endslot
                @endcomponent
                {{--分页--}}
                @include('paginate-components.paginate',['models'=>$douplus])
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
