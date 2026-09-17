@props(['comment'])

@php
    $author = $comment->user->userProfile?->user_name ?? $comment->user->email;
@endphp

<article class="mb-8 last:mb-0">
    <div class="flex items-start gap-3">
        <a
            href="{{ url('/profiles/' . $comment->user->userProfile->user_name) }}"
            class="shrink-0"
            aria-label="Open {{ $author }} profile"
        >
            <x-user.avatar :user="$comment->user" />
        </a>

        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                <a
                    href="{{ url('/profiles/' . $comment->user->userProfile->user_name) }}"
                    class="truncate font-display text-base font-bold text-sol-night transition hover:text-sol-mars"
                >
                    {{ $author }}
                </a>

                <time
                    datetime="{{ $comment->created_at->toIso8601String() }}"
                    class="shrink-0 font-body text-[9px] font-semibold uppercase tracking-[0.14em] text-sol-muted"
                >
                    {{ $comment->created_at->diffForHumans() }}
                </time>
            </div>

            <p class="mt-2 font-body text-sm leading-6 text-sol-ink">
                {{ $comment->body }}
            </p>
        </div>
    </div>
</article>
