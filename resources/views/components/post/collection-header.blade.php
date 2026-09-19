@props([
    'eyebrow',
    'title',
    'count' => null,
    'backHref' => null,
    'backLabel' => 'Back',
])

<header class="mb-8">
    @if ($backHref)
        <a
            href="{{ $backHref }}"
            class="group inline-flex items-center gap-3 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-muted transition hover:text-sol-mars"
        >
            <svg
                class="size-4 transition group-hover:-translate-x-1"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.7"
                aria-hidden="true"
            >
                <path d="m15 18-6-6 6-6"></path>
            </svg>

            {{ $backLabel }}
        </a>
    @endif

    <div class="mt-6 flex items-center gap-3">
        <span class="h-px w-10 bg-sol-orange"></span>

        <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
            {{ $eyebrow }}
        </p>
    </div>

    <div class="mt-4 flex flex-wrap items-end justify-between gap-4">
        <h1 class="font-display text-3xl font-bold text-sol-night sm:text-4xl">
            {{ $title }}
        </h1>

        @isset($count)
            <span class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted">
                {{ $count }} {{ \Illuminate\Support\Str::plural('result', $count) }}
            </span>
        @endisset
    </div>
</header>
