<x-layouts.app :title="'Sol '.str_pad($imagePost->id, 3, '0', STR_PAD_LEFT).' · SOL4'">
    @php
        $media = $imagePost->media->first();
    @endphp

    {{-- Back link --}}
    <a
        href="{{ url('/') }}"
        class="group inline-flex items-center gap-3 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-muted transition hover:text-sol-mars"
    >
        <svg class="size-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
            <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back to image orbit
    </a>

    <div class="mt-8 grid items-start gap-12 xl:grid-cols-[minmax(0,1fr)_25rem]">
        {{-- Image post --}}
        <article class="min-w-0">
            <header class="flex items-center justify-between gap-5 px-1 pb-5">
                <x-post.author :user="$imagePost->user" :time="$imagePost->created_at" size="lg" />

                <div class="flex shrink-0 items-center gap-5">
                    @can('modify', $imagePost)
                        <a
                            href="{{ url('/sol/'.$imagePost->id.'/edit') }}"
                            class="font-body text-[9px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars"
                        >
                            Edit
                        </a>
                    @endcan

                    <span class="flex items-center gap-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
                        <span class="h-5 w-px bg-sol-orange"></span>
                        Sol {{ str_pad($imagePost->id, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </header>

            {{-- Image: 3:4 frame, whole image always visible (object-contain). --}}
            <div class="mx-auto flex aspect-[3/4] w-full max-w-lg items-center justify-center overflow-hidden bg-sol-sand">
                @if ($media)
                    <img
                        src="{{ url($media->media_uri) }}"
                        alt="{{ $media->media_alt ?: $imagePost->image_title }}"
                        class="size-full object-contain"
                    >
                @else
                    <p class="px-8 text-center font-display text-xl font-bold text-sol-mars">
                        Image transmission unavailable
                    </p>
                @endif
            </div>

            <div class="px-1 pt-5">
                <x-post.actions :post="$imagePost" type="sol" commentsHref="#comments" />

                <h1 class="mt-5 max-w-4xl font-display text-2xl font-bold leading-8 text-sol-night sm:text-3xl sm:leading-10">
                    {{ $imagePost->image_title }}
                </h1>

                <x-post.tag-chips :tags="$imagePost->tags" type="sol" class="mt-5" />
            </div>
        </article>

        {{-- Comments (rendered by JS) --}}
        <x-comments.panel :endpoint="url('/sol/'.$imagePost->id.'/comments')" />
    </div>
</x-layouts.app>
