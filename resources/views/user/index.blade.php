@extends('layouts.master')

@section('title') 员工管理 @endsection

@inject('userModel','App\User')

@section('content')

    @component('common-components.breadcrumb')
        @slot('title') 员工管理  @endslot
        @slot('li_1') 团队管理  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            {{--部门侧边--}}
            @include('user.department._card')
            <div class="user-bar">
                {{--员工table--}}
                @include('user._card')
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
            });

            @error('*')
            Swal.fire({
                type: 'error',
                title: '{{ $message }}',
                showConfirmButton: false,
                timer: 2000
            });
            @enderror

        })
    </script>
@endsection

