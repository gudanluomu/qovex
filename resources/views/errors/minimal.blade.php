@extends('layouts.master-without-nav')

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="home-btn d-none d-sm-block">
            <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
        </div>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">

                            <div class="card-body">

                                <div class="text-center p-3">

                                    <div class="img">
                                        <img src="/images/error-img.png" class="img-fluid" alt="">
                                    </div>

                                    <h1 class="error-page mt-5"><span>@yield('code')!</span></h1>
                                    <h4 class="mb-4 mt-5">@yield('message')</h4>
                                    <p class="mb-4 w-75 mx-auto">{{  Arr::random(config('data.sentences')) }}</p>
                                    <a class="btn btn-primary mb-4 waves-effect waves-light" href="/index"><i
                                            class="mdi mdi-home"></i> {{ __('Back to Dashboard') }}</a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
