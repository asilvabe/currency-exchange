<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div class="flex items-center justify-center h-screen">
        @yield('main')
    </div>
<script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>
