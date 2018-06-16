<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">    
    <title>Enrollment Management System</title>
</head>

<body>

<div id="app">
<router-view></router-view>
</div>

<div id="error"></div>

<script>const DEBUG = {{ env('APP_DEBUG', false) }}</script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
