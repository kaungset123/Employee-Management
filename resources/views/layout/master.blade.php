<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <title>@yield('title')</title>
    <!-- Disable tap highlight on IE -->
    <!-- <meta name="msapplication-tap-highlight" content="no"> -->
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/select2.min.js') }}"></script>
    <script src="{{ asset('/js/alpine.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
    <link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{!! asset('/css/main.87c0748b313a1dda75f5.css') !!}" rel="stylesheet">
    <link href="{!! asset('/css/custom.css') !!}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/all.min.css') !!}">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        @include('layout.nav')
        <div class="app-main bg-white">
            @include('layout.sidebar')
            @yield('content')
        </div>
        <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.poper.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{!! asset('/js/main.87c0748b313a1dda75f5.js')!!}"></script>
        <script src="{{ asset('/js/app.js') }}"></script>
        <script type="text/javascript" src="{!! asset('/js/custom.js') !!}"></script>
    </div>
    @yield('script')
</body>

</html>