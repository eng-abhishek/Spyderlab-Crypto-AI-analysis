<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="utf-8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SpyderLab'))</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="icon" href="{{asset('assets/frontend/images/favicon.png')}}" type="image/png">
    <link href="{{asset('assets/frontend/images/favicon-light.png')}}" rel="icon" media="(prefers-color-scheme: light)"/>
    <link href="{{asset('assets/frontend/images/favicon-dark.png')}}" rel="icon" media="(prefers-color-scheme: dark)"/>

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{asset('assets/backend/css/vendor.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/backend/css/app.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/frontend/vendors/font-awesome-v6.2.0/css/all.css')}}">
    <!-- ================== END core-css ================== -->
    <style>
        .captcha{
            display: inline-block;
            height: 42px;
            object-fit: cover;
        }
        .captcha + a{
            height: 42px;
            /* line-height: 42px; */
            font-size: 24px;
        }
    </style>

    @yield('styles')

</head>

<!-- BEGIN #app -->
<div id="app" class="app app-full-height app-without-header">

    @yield('content')

    <!-- BEGIN btn-scroll-top -->
    <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
    <!-- END btn-scroll-top -->
</div>
<!-- END #app -->

<!-- ================== BEGIN core-js ================== -->
<script src="{{asset('assets/backend/js/vendor.min.js')}}"></script>
<script src="{{asset('assets/backend/js/app.min.js')}}"></script>
<!-- ================== END core-js ================== -->

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

@yield('scripts')

</html>