<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f0e7">
    <title>403 · Restricted orbit · SOL4</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-sol-panel font-body text-sol-ink antialiased">
    <main class="grid min-h-screen place-items-center px-6 py-16">
        <section class="w-full max-w-md text-center">
            <span class="mx-auto grid size-16 place-items-center rounded-full border border-sol-line bg-sol-paper">
                <svg class="size-8 text-sol-mars" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <rect x="5" y="11" width="14" height="9" rx="1.5"></rect>
                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                    <circle cx="12" cy="15.5" r="1.2"></circle>
                </svg>
            </span>

            <p class="mt-8 font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">Error 403</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-sol-night sm:text-5xl">Restricted orbit</h1>
            <p class="mt-4 font-body text-sm leading-6 text-sol-muted">
                You don&rsquo;t have clearance to reach this transmission. If this looks wrong, try signing in with an authorised account.
            </p>

            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ url('/') }}"
                   class="inline-flex min-h-12 items-center justify-center bg-sol-mars px-8 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-panel transition hover:bg-sol-orange">
                    Back to orbit
                </a>
                <a href="{{ url('/login') }}"
                   class="inline-flex min-h-12 items-center justify-center border border-sol-line bg-sol-paper px-8 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-mars transition hover:border-sol-orange">
                    Log in
                </a>
            </div>
        </section>
    </main>
</body>
</html>
