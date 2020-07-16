@extends('layouts.master')

@section('title') 抖音视频管理 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 抖音视频管理  @endslot
        @slot('li_1') 内容管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">抖音视频列表</h4>
                    <p class="card-title-desc">管理团队的所有抖音视频</p>
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
            </div>
        </div>
        @foreach($videos as $video)
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body d-flex video-card">
                        <div class="video-cover bg-cover position-relative"
                             style="background-image: url('{{ $video->origin_cover }}');">
                            @if($video->with_fusion_goods)
                                <div class="video-product" data-toggle="popover"
                                     data-content-id="#popover_content_{{$video->id}}"
                                     data-trigger="hover">
                                    <i class="mdi mdi-18px mdi-shopping text-warning"></i>
                                </div>
                                <div class="d-none" id="popover_content_{{$video->id}}">
                                    @foreach($video->products as $product)
                                        <div class="d-flex mb-2">
                                            <div class="product-cover bg-cover"
                                                 style="background-image: url({{ $product->images }});">
                                            </div>
                                            <div
                                                class="ml-2 d-flex flex-column justify-content-around"
                                                style="width: 200px">
                                                <h5 class="card-title">{{ $product->title }}</h5>
                                                <p class="card-text">
                                                    {{ $product->goods_source }}
                                                </p>
                                                <p class="card-text">
                                                    佣金比例:<small class="text-muted">{{ $product->custom_rate }}
                                                        %</small>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="video-info ml-3 d-flex flex-column">
                            <div>{!! $video->desc_link !!}</div>
                            <div class="d-flex">
                                @foreach($video->statistics as $v)
                                    <div class="mr-3 font-size-13" data-toggle="tooltip" title="{{ $v['title'] }}"><i
                                            class="mdi mdi-{{$v['icon']}}"></i> {{ $v['value'] }}</div>
                                @endforeach
                            </div>
                            <div>{{ $video->create_time_str }}</div>
                            <div>{{ $video->status_value_desc }}</div>
                            <div>{{ $video->sync_time_desc }}</div>
                            <div class="video-btn">
                                <ui class="list-inline social-source-list">
                                    @foreach($video->video_btns as $btn)
                                        <li class="list-inline-item">
                                            <div class="avatar-xs">
                                                <a href="{{ $btn['url'] }}" data-toggle="tooltip"
                                                   title="{{ $btn['title'] }}"
                                                   class="avatar-title rounded-circle {{ $btn['class'] }}">
                                                    <i class="mdi mdi-{{$btn['icon']}}"></i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ui>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{--分页--}}
        <div class="col-12">
            @include('paginate-components.paginate',['models'=>$videos])
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('css')
    <style>
        .video-card:hover .video-btn {
            visibility: visible;
            opacity: 1;
        }

        a.avatar-title:hover {
            color: #fff;
        }

        .popover {
            max-width: 300px !important;
        }

        .video-cover {
            height: 200px;
            width: 150px;
            border-radius: 4px;
            overflow: hidden;
        }

        .product-cover {
            height: 100px;
            width: 80px;
            border-radius: 4px;
            overflow: hidden;
        }

        .bg-cover {
            background-color: rgb(0, 0, 0);
            background-size: 100%;
            background-position-y: 50%;
            background-repeat: no-repeat;
        }

        .video-info > div {
            margin-bottom: .5rem;
        }

        .video-product {
            position: absolute;
            left: 10px;
            bottom: 10px;
            padding: 4px;
            background: rgba(0, 0, 0, 0.75);
            border-radius: 2px;
        }

        .video-btn {
            margin-top: auto;
            margin-bottom: 0;
            visibility: hidden;
            opacity: 0;
            transition: all .15s ease-in
        }
    </style>
@endsection



