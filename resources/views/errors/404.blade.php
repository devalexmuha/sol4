<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f0e7">
    <title>404 · Signal lost · SOL4</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-sol-panel font-body text-sol-ink antialiased">
    <main class="grid min-h-screen place-items-center px-6 py-16">
        <section class="w-full max-w-md text-center">
            <span class="mx-auto grid size-16 place-items-center rounded-full border border-sol-line bg-sol-paper">
                <svg class="size-8 text-sol-mars" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <circle cx="12" cy="12" r="3.2"></circle>
                    <ellipse cx="12" cy="12" rx="10" ry="4.4" transform="rotate(30 12 12)"></ellipse>
                </svg>
            </span>

            <p class="mt-8 font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">Error 404</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-sol-night sm:text-5xl">Signal not found</h1>
            <p class="mt-4 font-body text-sm leading-6 text-sol-muted">
                This transmission drifted out of range — the page you were looking for isn&rsquo;t in orbit.
            </p>

            <a href="{{ url('/') }}"
               class="mt-8 inline-flex min-h-12 items-center justify-center bg-sol-mars px-8 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-panel transition hover:bg-sol-orange">
                Back to orbit
            </a>
        </section>
    </main>
</body>
</html>
