@props([
    'eyebrow',
    'title',
    'cancel' => null,
])

<header class="flex items-end justify-between gap-6">
    <div>
        <div class="flex items-center gap-3">
            <span class="h-px w-10 bg-sol-orange"></span>

            <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                {{ $eyebrow }}
            </p>
        </div>

        <h1 class="mt-4 font-display text-3xl font-bold text-sol-night sm:text-4xl">
            {{ $title }}
        </h1>
    </div>

    @if ($cancel)
        <a
            href="{{ $cancel }}"
            class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars"
        >
            Cancel
        </a>
    @endif
</header>
