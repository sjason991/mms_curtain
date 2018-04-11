<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api_token" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        @include('layouts.header')
        @include('layouts.sidebar')
    </nav>
    <div id="page-wrapper">
        <div id="app">
            @yield('content')
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
{{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
