@extends('layouts.master')

@section('title') 权限管理 @endsection
@section('css')

    <!-- DataTables -->
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 权限管理  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-6">
                            @component('common-components.card-title')
                                @slot('title') 权限列表  @endslot
                                @slot('desc')管理团队的所有权限  @endslot
                            @endcomponent
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <button class="btn btn-primary">添加权限</button>
                            </div>
                        </div>
                    </div>


                    @include('form-components.form-search',['formGroup' => [
    ['text' => '名称','name' => 'name']
]])

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>权限名称</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <th>{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @include('paginate-components.paginate',['models'=>$roles])
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
