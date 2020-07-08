@extends('layouts.master')

@section('title') 抖音账号管理 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 抖音账号管理  @endslot
        @slot('li_1') 内容管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">抖音账号列表</h4>
                    <p class="card-title-desc">管理团队的所有抖音账号</p>
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
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#douyinUserQrcode"><i
                                class="mdi mdi-qrcode-plus"></i> 扫码添加</a>
                    </div>
                </div>
                {{--表格--}}
                @component('table-components.table-responsive')
                    @slot('head')
                        <tr>
                            <th>账号</th>
                            <th>手机</th>
                            <th>UID</th>
                            <th>UNIQUE ID</th>
                            <th>作品数</th>
                            <th>关注数</th>
                            <th>粉丝数</th>
                            <th>橱窗</th>
                            <th>橱窗</th>
                            <th>绑定淘宝</th>
                            <th>商店</th>
                            <th>PID</th>
                            <th>member_id</th>
                            <th>site_id</th>
                            <th>adzone_id</th>
                            <th>cookie_status</th>
                            <th>pid更新时间</th>
                            <th>信息更新时间</th>
                            <th>控评</th>
                            <th>到期时间</th>
                            <th>操作</th>
                        </tr>
                    @endslot
                    @slot('body')
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nickname }}</td>
                                <td>{{ $user->bind_phone }}</td>
                                <td>{{ $user->uid }}</td>
                                <td>{{ $user->unique_id }}</td>
                                <td>{{ $user->aweme_count }}</td>
                                <td>{{ $user->following_count }}</td>
                                <td>{{ $user->follower_count }}</td>
                                <td>{{ $user->with_fusion_shop_entry }}</td>
                                <td>{{ $user->with_commerce_entry }}</td>
                                <td>{{ $user->bind_taobao_pub }}</td>
                                <td>{{ $user->with_shop_entry }}</td>
                                <td>{{ $user->pid }}</td>
                                <td>{{ $user->member_id }}</td>
                                <td>{{ $user->site_id }}</td>
                                <td>{{ $user->adzone_id }}</td>
                                <td>{{ $user->cookie_status }}</td>
                                <td>{{ $user->pid_update_time }}</td>
                                <td>{{ $user->info_update_time }}</td>
                                <td>{{ $user->del_comment_at }}</td>
                                <td>
                                    <span
                                        @if($user->isExpired()) style="color: red;" data-toggle="tooltip"
                                        title="已到期,请重新授权" @endif>{{ $user->cookie_expire_time }}</span>
                                </td>
                                <td>
                                    <a class="font-size-18" delete data-toggle="tooltip" title="删除" href="">
                                        <i class="mdi mdi-delete-off-outline"></i></a>
                                    <form class="d-none" method="post"
                                          action="{{ route('douyin.user.destroy',$user) }}">@method('DELETE')@csrf</form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                @endcomponent
                {{--分页--}}
                @include('paginate-components.paginate',['models'=>$users])
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="modal" id="douyinUserQrcode" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">扫码添加</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="qrcode-image">
                        <img src="" alt="正在加载二维码">
                    </div>
                    <p>打开 <code>抖音短视频APP</code> 扫描二维码 <br> 点击「首页」-「搜索」-「扫一扫」</p>
                    <p class="text-danger qrcode-error"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script !src="">
        $('#douyinUserQrcode').on('show.bs.modal', function () {
            //获取二维码
            $.ajax({
                url: '/douyin/user/get-qrcode',
                success: function (response) {
                    verifyResponse(response)
                }
            })
        });

        function checkQrcode(token) {
            $.ajax({
                url: '/douyin/user/check-qrcode/' + token,
                success: function (response) {
                    verifyResponse(response, token)
                },
                error: function (error) {
                    $('.qrcode-error').html(error.responseJSON.message || '服务器错误,请刷新页面后重试~')
                }
            })
        }

        //校验返回内容
        function verifyResponse(response, token) {
            if (response.message == 'success') {
                if (response.data.status === undefined || response.data.status === 'expired') {
                    $('.qrcode-image img').attr('src', 'data:image/png;base64,' + response.data.qrcode);
                    token = response.data.token
                }

                if (response.data.status === 'confirmed') {
                    window.location.reload()
                } else {
                    setTimeout(checkQrcode, 2000, token)
                }

            } else {
                $('.qrcode-error').html('服务器错误,请刷新页面后重试~')
            }
        }

        $('#douyinUserQrcode').on('show.bs.modal', function () {
            $('.qrcode-error').html('');

            clearTimeout(checkQrcode)
        });
    </script>
@endsection

@section('css')
    <style>
        .qrcode-image {
            width: 200px;
            height: 200px;
            margin: 18px auto;
            position: relative;
        }

        .qrcode-image > img {
            width: 100%;
            height: 100%;
        }

        .qrcode-image > div {
            position: absolute;
            top: 0;
            left: 0;
        }

        .qrcode-image .logo {
            width: 38px;
            height: 38px;
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
@endsection
