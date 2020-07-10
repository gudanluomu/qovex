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
                    <h4 class="card-title">DOU+投放</h4>
                    <p class="card-title-desc">给你的视频加热~~</p>

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <form method="post" action="{{ route('douplus.store') }}">
                                <input type="hidden" name="video_id" value="{{ $video->id }}">
                                <div class="form-group">
                                    <label>期望提升:</label>

                                    <select name="aim" class="form-control select2"
                                            data-minimum-results-for-search="Infinity">
                                        @foreach($aim as $k=>$v)
                                            <option value="{{ $k }}" {{ old('aim') == $k ? 'selected' : '' }}>
                                                {{ $v }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>投放时长:</label>

                                    <select name="duration" class="form-control select2"
                                            data-minimum-results-for-search="Infinity">
                                        @foreach($duration as $k=>$v)
                                            <option value="{{ $k }}" {{ old('duration') == $k ? 'selected' : '' }}>
                                                {{ $v }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>推荐方式:</label>

                                    <div class="input-group">
                                        @foreach($delivery_type as $k => $v)
                                            <div class="custom-control custom-radio mb-2 mr-4">
                                                <input type="radio" class="custom-control-input"
                                                       name="delivery_type" value="{{ $k }}"
                                                       id="delivery_type_{{$k}}"
                                                       @if($k==old('delivery_type',1)) checked @endif>
                                                <label class="custom-control-label delivery_type_tab"
                                                       for="delivery_type_{{$k}}"
                                                       data-href="#tab_delivery_type_{{ $k }}">
                                                    {{ $v }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div
                                        class="tab-pane tab_delivery_type  @if(old('delivery_type',1) == $k) active @endif"
                                        id="tab_delivery_type_2">
                                        @foreach($custom_options as $k => $v)
                                            <div class="form-group">
                                                <label>{{ $v['title'] }}:</label>
                                                <div class="input-group">
                                                    @if($v['multiple'])
                                                        @foreach($v['data'] as $key => $val)
                                                            <div class="custom-control custom-checkbox mb-2 mr-4">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       name="{{$k}}[]"
                                                                       id="{{ $k }}_{{$key}}" value="{{ $key }}"
                                                                       @if(in_array($key,old($k,[]))) checked @endif>
                                                                <label class="custom-control-label"
                                                                       for="{{ $k }}_{{$key}}">{{ $val }}</label>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        @foreach($v['data'] as $key => $val)
                                                            <div class="custom-control custom-radio mb-2 mr-4">
                                                                <input type="radio" class="custom-control-input"
                                                                       name="{{$k}}"
                                                                       id="{{ $k }}_{{$key}}" value="{{ $key }}"
                                                                       @if($key==old($k)) checked @endif>
                                                                <label class="custom-control-label"
                                                                       for="{{ $k }}_{{$key}}">{{ $val }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>投放金额:</label>

                                    <select name="budget" class="form-control select2"
                                            data-minimum-results-for-search="Infinity">
                                        @foreach($budget as $k=>$v)
                                            <option value="{{ $k }}" {{ old('budget') == $k ? 'selected' : '' }}>
                                                {{ $v }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>投放次数:</label>
                                    <input data-toggle="touchspin" type="text" value="{{ old('num',1) }}" name="num">
                                </div>

                                <div class="form-group">
                                    <label for="name">付款账号:</label>
                                    <div class="input-group is-invalid">
                                        <select name="pay_user_id" class="form-control select2"
                                                @if($payUsers->count() < 10) data-minimum-results-for-search="Infinity" @endif>
                                            @foreach($payUsers as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('pay_user_id',$video->dyuser->id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nickname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pay_user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                @include('douplus._save-package')

                                <button class="btn btn-primary btn-rounded px-4" type="submit">提交</button>
                                <a href="{{ route('douyin.video.index') }}" class="btn btn-secondary btn-rounded px-4"
                                   type="submit">返回</a>

                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('script')
    <script src="{{URL::asset('/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script !src="">
        $('[data-toggle="touchspin"]').each(function (idx, obj) {
            var objOptions = $.extend({}, {}, $(obj).data());
            $(obj).TouchSpin(objOptions);
        });

        $('.delivery_type_tab').click(function (e) {
            var href = $(this).data('href');
            $('.tab_delivery_type').removeClass('active');
            $(href).addClass('active')
        });

        $('#save_package').change(function () {
            if ($(this).prop('checked')) {
                $('#tab_save_package').addClass('active')
            } else {
                $('#tab_save_package').removeClass('active')
            }
        })
    </script>
@endsection
