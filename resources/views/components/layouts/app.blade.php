@props(['title' => 'SOL4'])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f0e7">

    {{-- JS bootstrap: CSRF token + auth/login/register endpoints. --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ url('/login') }}">
    <meta name="register-url" content="{{ url('/register') }}">

    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="min-h-screen font-body text-sol-ink antialiased"
    @auth data-auth-id="{{ auth()->id() }}" @endauth
>
<div class="relative min-h-screen w-full overflow-x-hidden">
        <x-navigation.main-header/>

        <main class="relative w-full max-w-300 mx-auto px-4 pb-28 pt-8 mt-16 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <x-navigation.bottom-nav/>
</div>
</body>
</html>
