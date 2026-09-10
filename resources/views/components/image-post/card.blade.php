@props(['post'])

@php
    $media = $post->media->first();
    $likesCount = $post->likes_count ?? $post->likes->count();
    $commentsCount = $post->comments_count ?? $post->comments->count();
@endphp

<article {{ $attributes->class('relative w-full overflow-hidden rounded-sol bg-sol-panel') }}>
    <a
        href="{{ url('/image-post/'.$post->id) }}"
        class="absolute inset-0 z-10"
        aria-label="Open image post by {{ $post->user->name }}"
    ></a>

    <header class="flex items-center justify-between gap-4 border-b border-sol-line px-1 py-4 sm:px-2">
        <a
            href="{{ url('/profile/'.$post->user->id) }}"
            class="group relative z-20 flex min-w-0 items-center gap-3"
        >
            <x-user.avatar :user="$post->user" />

            <span class="min-w-0">
                <span class="block truncate font-display text-base font-bold text-sol-night transition group-hover:text-sol-mars">
                    {{ $post->user->name }}
                </span>
                <span class="block font-body text-[10px] font-semibold uppercase tracking-[0.14em] text-sol-muted">
                    {{ $post->created_at->diffForHumans() }}
                </span>
            </span>
        </a>

        <span class="border-l-2 border-sol-orange pl-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
            Sol {{ str_pad($post->id, 3, '0', STR_PAD_LEFT) }}
        </span>
    </header>

    <div class="relative block aspect-[4/5] overflow-hidden bg-sol-sand sm:aspect-[16/9] xl:aspect-[21/9]">
        @if ($media)
            <img
                src="{{ $media->media_uri }}"
                alt="{{ $media->media_alt ?: $post->image_title }}"
                class="size-full object-cover transition duration-500 hover:scale-[1.015]"
                loading="lazy"
            >
        @else
            <span class="grid size-full place-items-center px-8 text-center font-display text-lg font-bold text-sol-mars">
                Image transmission unavailable
            </span>
        @endif
    </div>

    <div class="px-1 py-4 sm:px-2">
        <div class="mb-4 flex items-center gap-6 border-sol-line">
            <div
                class="flex items-center gap-2 font-body text-sm font-bold text-sol-night"
                aria-label="{{ $likesCount }} likes"
            >
                <svg class="size-5 text-sol-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"></path>
                </svg>
                <span>{{ $likesCount }}</span>
            </div>

            <a
                href="{{ url('/image-post/'.$post->id) }}#comments"
                class="relative z-20 flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
                aria-label="{{ $commentsCount }} comments"
            >
                <svg class="size-5 text-sol-amber" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path d="M21 12a8 8 0 0 1-8 8 8.7 8.7 0 0 1-3.7-.8L4 20l1.2-3.4A8 8 0 1 1 21 12Z"></path>
                </svg>
                <span>{{ $commentsCount }}</span>
            </a>
        </div>

        <h2 class="font-display text-xl font-bold leading-7 text-sol-night transition hover:text-sol-mars">
            {{ $post->image_title }}
        </h2>

        @if ($post->tags->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($post->tags->take(3) as $tag)
                    <span class="rounded-sm border border-sol-line bg-sol-paper px-2 py-1 font-body text-[10px] font-bold uppercase tracking-wider text-sol-mars">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</article>
