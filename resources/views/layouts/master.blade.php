<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | Qovex - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico')}}">
    @include('layouts.head')
</head>

@section('body')
@show
<body data-layout="detached" data-topbar="colored">
<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>
<!-- Begin page -->
<div class="container-fluid">
    <div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @yield('content')
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
</div>
<!-- END container-fluid -->


<!-- Right Sidebar -->
@include('layouts.right-sidebar')
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('layouts.footer-script')

<script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('/libs/select2/i18n/zh-CN.js')}}"></script>
<script src="{{ URL::asset('/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<script>
    /*表单错误信息清除*/
    $(document).ready(function () {
        $('form .is-invalid').click(function () {
            $(this).removeClass('is-invalid')
        });

        $('.table-data [delete]').click(function (event) {
            event.preventDefault();

            if (confirm('确定删除?'))
                $(this).next('form').submit()
        });

        $(".select2").select2({
            language: "zh-CN",
            width: '100%',
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                if ($(data.element).data('html'))
                    return $(data.element).data('html');

                return data.text;
            },
        });
    })
</script>
</body>

</html>
