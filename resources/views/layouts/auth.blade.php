<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#090909">
    <title>@yield('title', 'Sign in | Mars Collection')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=20260930" sizes="any">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon.png') }}?v=20260930">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=20260930">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>
<body class="min-h-screen bg-[#f7f6f3] font-sans antialiased text-gray-950">
    @yield('content')
</body>
</html>
