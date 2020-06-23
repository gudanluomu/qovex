@extends('layouts.master')

@section('title') 编辑团队 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 编辑团队  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">编辑团队</h4>
                    <p class="card-title-desc">编辑一个已存在的团队</p>

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <form method="post" action="{{ route('group.update',$group) }}">

                                @include('group._field')

                                <button class="btn btn-primary btn-rounded px-4" type="submit">提交</button>
                                <a href="{{ route('group.index') }}" class="btn btn-secondary btn-rounded px-4"
                                   type="submit">返回</a>
                                @method('PUT')
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
