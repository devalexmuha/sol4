@props(['post'])

@php
    $media = $post->media->first();
@endphp

<article {{ $attributes->class('relative w-full overflow-hidden rounded-sol bg-sol-panel') }}>
    <a
        href="{{ url('/sol/'.$post->id) }}"
        class="absolute inset-0 z-10"
        aria-label="Open image post by {{ $post->user->userProfile->user_name }}"
    ></a>

    <header class="flex items-center justify-between gap-4 border-b border-sol-line px-1 py-4 sm:px-2">
        <a
            href="{{ url('/profiles/' . $post->user->userProfile->user_name) }}"
            class="group relative z-20 flex min-w-0 items-center gap-3"
        >
            <x-user.avatar :user="$post->user" />

            <span class="min-w-0">
                <span class="block truncate font-display text-base font-bold text-sol-night transition group-hover:text-sol-mars">
                    {{ $post->user->userProfile->user_name }}
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
                src="{{ url($media->media_uri) }}"
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
        <x-post.actions
            :post="$post"
            type="sol"
            :commentsHref="url('/sol/'.$post->id).'#comments'"
            class="mb-4"
        />

        <h2 class="font-display text-xl font-bold leading-7 text-sol-night transition hover:text-sol-mars">
            {{ $post->image_title }}
        </h2>

        <x-post.tag-chips :tags="$post->tags" type="sol" :limit="3" class="mt-4" />
    </div>
</article>
