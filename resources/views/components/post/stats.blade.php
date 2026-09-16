@props([
    'likes' => 0,
    'comments' => 0,
    'commentsHref' => '#comments',
])

<div {{ $attributes->class('flex items-center gap-7') }}>
    <span
        class="flex items-center gap-2 font-body text-sm font-bold text-sol-night"
        aria-label="{{ $likes }} likes"
    >
        <svg
            class="size-5 text-sol-orange"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.7"
            aria-hidden="true"
        >
            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"></path>
        </svg>

        <span>{{ $likes }}</span>
    </span>

    <a
        href="{{ $commentsHref }}"
        class="group relative z-20 flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
        aria-label="{{ $comments }} comments"
    >
        <svg
            class="size-5 text-sol-amber transition group-hover:scale-110"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.7"
            aria-hidden="true"
        >
            <path d="M21 12a8 8 0 0 1-8 8 8.7 8.7 0 0 1-3.7-.8L4 20l1.2-3.4A8 8 0 1 1 21 12Z"></path>
        </svg>

        <span>{{ $comments }}</span>
    </a>
</div>
