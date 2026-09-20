<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f0e7">
    <title>503 · Recalibrating · SOL4</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-sol-panel font-body text-sol-ink antialiased">
    <main class="grid min-h-screen place-items-center px-6 py-16">
        <section class="w-full max-w-md text-center">
            <span class="mx-auto grid size-16 place-items-center rounded-full border border-sol-line bg-sol-paper">
                <svg class="size-8 text-sol-mars" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path d="M14.7 6.3a4 4 0 0 0-5.4 5.4l-6 6 2 2 6-6a4 4 0 0 0 5.4-5.4l-2.3 2.3-2-2 2.3-2.3Z"></path>
                </svg>
            </span>

            <p class="mt-8 font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">Error 503</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-sol-night sm:text-5xl">Systems recalibrating</h1>
            <p class="mt-4 font-body text-sm leading-6 text-sol-muted">
                SOL4 is down for brief maintenance while we tune the array. We&rsquo;ll be back in orbit shortly &mdash; thanks for your patience.
            </p>

            <a href="{{ url()->current() }}"
               class="mt-8 inline-flex min-h-12 items-center justify-center bg-sol-mars px-8 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-panel transition hover:bg-sol-orange">
                Try again
            </a>
        </section>
    </main>
</body>
</html>
