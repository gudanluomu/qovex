@extends('layouts.master')

@section('title') 新增权限 @endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 新增权限  @endslot
        @slot('li_1') 权限管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">添加权限</h4>
                    <p class="card-title-desc">新添加一个权限</p>

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <form method="post" action="{{ route('role.store') }}">
                                @include('role._field')

                                <button class="btn btn-primary btn-rounded px-4" type="submit">提交</button>
                                <a href="{{ route('role.index') }}" class="btn btn-secondary btn-rounded px-4"
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
