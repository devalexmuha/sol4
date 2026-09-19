@props([
    'post',
    'type',                 // 'sol' (image) or 'echoes' (text)
    'commentsHref' => null, // when set, the comment icon is a link; otherwise a scroll anchor
])

@php
    $seg = $type === 'echoes' ? 'echoes' : 'sol';

    $likesCount    = $post->likes_count    ?? (isset($post->likes)    ? $post->likes->count()    : 0);
    $commentsCount = $post->comments_count ?? (isset($post->comments) ? $post->comments->count() : 0);

    // Viewer-state flags provided by the backend (see backend notes). Default false.
    $liked     = (bool) ($post->viewer_has_liked ?? false);
    $commented = (bool) ($post->viewer_has_commented ?? false);

    $commentsHref ??= url('/'.$seg.'/'.$post->id).'#comments';
@endphp

<div {{ $attributes->class('flex items-center gap-7') }}>
    {{-- Like (interactive) --}}
    <button
        type="button"
        data-like-toggle
        data-endpoint="{{ url('/'.$seg.'/'.$post->id.'/likes') }}"
        data-liked="{{ $liked ? 'true' : 'false' }}"
        aria-pressed="{{ $liked ? 'true' : 'false' }}"
        aria-label="Like this {{ $seg === 'echoes' ? 'echo' : 'sol' }}"
        class="group relative z-20 flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
    >
        <svg
            class="size-5 text-sol-orange transition group-hover:scale-110"
            viewBox="0 0 24 24"
            fill="{{ $liked ? 'currentColor' : 'none' }}"
            stroke="currentColor"
            stroke-width="1.7"
            aria-hidden="true"
            data-like-icon
        >
            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"></path>
        </svg>

        <span data-like-count>{{ $likesCount }}</span>
    </button>

    {{-- Comments (link / scroll anchor) --}}
    <a
        href="{{ $commentsHref }}"
        class="group relative z-20 flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
        aria-label="{{ $commentsCount }} comments"
    >
        <svg
            class="size-5 text-sol-amber transition group-hover:scale-110"
            viewBox="0 0 24 24"
            fill="{{ $commented ? 'currentColor' : 'none' }}"
            stroke="currentColor"
            stroke-width="1.7"
            aria-hidden="true"
        >
            <path d="M21 12a8 8 0 0 1-8 8 8.7 8.7 0 0 1-3.7-.8L4 20l1.2-3.4A8 8 0 1 1 21 12Z"></path>
        </svg>

        <span data-comment-count>{{ $commentsCount }}</span>
    </a>
</div>
