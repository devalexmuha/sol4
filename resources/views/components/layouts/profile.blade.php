@props([
    'title' => 'Profile',
])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }} · SOL4</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-sol-panel font-body text-sol-ink antialiased">
<div class="relative min-h-screen w-full overflow-x-hidden">
    <main class="w-full pb-24">
        {{ $slot }}
    </main>

    <x-navigation.profile-bottom-nav />
</div>
</body>
</html>
