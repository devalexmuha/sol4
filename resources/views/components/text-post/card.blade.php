@props(['post'])

@php
    $likesCount = $post->likes_count ?? $post->likes->count();
    $commentsCount = $post->comments_count ?? $post->comments->count();
@endphp

<article {{ $attributes->class('relative w-full overflow-hidden rounded-sol bg-sol-panel') }}>
    <a
        href="{{ url('/echoes/'.$post->id) }}"
        class="absolute inset-0 z-10"
        aria-label="Open text post by {{ $post->user->userProfile?->user_name ?? $post->user->email }}"
    ></a>

    <header class="flex items-center justify-between gap-4 border-b border-sol-line px-1 py-4 sm:px-2">
        <x-post.author :user="$post->user" :time="$post->created_at" class="relative z-20" />

        <span class="border-l-2 border-sol-orange pl-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
            Echo {{ str_pad($post->id, 3, '0', STR_PAD_LEFT) }}
        </span>
    </header>

    <div class="relative border-l-2 border-sol-orange bg-sol-paper/55 px-5 py-6 sm:px-7">
        <p class="font-display text-lg font-bold leading-8 text-sol-night sm:text-xl">
            {{ \Illuminate\Support\Str::limit($post->content, 220) }}
        </p>
    </div>

    <div class="px-1 py-4 sm:px-2">
        <x-post.stats
            :likes="$likesCount"
            :comments="$commentsCount"
            :commentsHref="url('/echoes/'.$post->id).'#comments'"
            class="mb-4"
        />

        <x-post.tag-chips :tags="$post->tags" :limit="3" />
    </div>
</article>
