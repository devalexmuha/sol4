@php
    $avatar = $user_profile->media->first();
    $showEchoes = $post_type === 'echoes';
@endphp

<x-layouts.profile :title="$user_profile->user_name">
    <div class="mx-auto w-full max-w-300 px-4 pb-12 pt-7 sm:px-6 sm:pt-10 lg:px-8">
        <a
            href="{{ url('/') }}"
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
                <path d="M19 12H5M10 7l-5 5 5 5"></path>
            </svg>

            <span>Return to the public orbit</span>
        </a>

        <section class="mt-12 sm:mt-16">
            <div class="grid items-start gap-8 sm:grid-cols-[9rem_minmax(0,1fr)] sm:gap-12">
                <div class="relative w-fit">
                    @if ($avatar)
                        <img
                            src="{{ $avatar->media_uri }}"
                            alt="{{ $avatar->media_alt ?: $user_profile->user_name.' profile image' }}"
                            class="size-28 rounded-full object-cover sm:size-36"
                        >
                    @else
                        <div
                            class="grid size-28 place-items-center rounded-full bg-sol-night font-display text-4xl font-bold uppercase text-sol-sand sm:size-36">
                            {{ mb_substr($user_profile->user_name, 0, 1) }}
                        </div>
                    @endif

                    <a
                        href="{{ url('/profile/'.$user_profile->user_id.'/edit') }}"
                        class="absolute bottom-0 right-0 grid size-10 place-items-center rounded-full bg-sol-mars text-sol-panel shadow-sol-card transition hover:bg-sol-orange"
                        aria-label="Edit profile"
                        title="Edit profile"
                    >
                        <svg
                            class="size-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.4-2.4 1a8 8 0 0 0-1.8-1L14.4 3h-4.8l-.3 3.1a8 8 0 0 0-1.8 1l-2.4-1-2 3.4 2 1.5a7 7 0 0 0 0 2l-2 1.5 2 3.4 2.4-1a8 8 0 0 0 1.8 1l.3 3.1h4.8l.3-3.1a8 8 0 0 0 1.8-1l2.4 1 2-3.4-2-1.5a7 7 0 0 0 .1-1Z"></path>
                        </svg>
                    </a>
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-4">
                        <h1 class="truncate font-display text-3xl font-bold text-sol-night sm:text-4xl">
                            {{ $user_profile->user_name }}
                        </h1>

                        <span class="h-px min-w-8 flex-1 bg-sol-orange"></span>
                    </div>

                    @if ($user_profile->user_bio)
                        <p class="mt-5 max-w-2xl font-body text-sm leading-7 text-sol-muted">
                            {{ $user_profile->user_bio }}
                        </p>
                    @endif

                    <div class="mt-8 grid max-w-lg grid-cols-3 gap-6">
                        <div>
                            <span class="block font-display text-2xl font-bold text-sol-night">
                                {{ $image_posts_count + $text_posts_count }}
                            </span>

                            <span
                                class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                                Signals
                            </span>
                        </div>

                        <a href="{{ url('/profile/subscribers') }}" class="group">
                            <span
                                class="block font-display text-2xl font-bold text-sol-night transition group-hover:text-sol-mars">
                                {{ $subscribers_count }}
                            </span>

                            <span
                                class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                                Subscribers
                            </span>
                        </a>

                        <a href="{{ url('/profile/subscriptions') }}" class="group">
                            <span
                                class="block font-display text-2xl font-bold text-sol-night transition group-hover:text-sol-mars">
                                {{ $subscriptions_count }}
                            </span>

                            <span
                                class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                                Subscriptions
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-16 sm:mt-20">
            <div class="mb-7 flex items-end justify-between gap-5">
                <p class="font-body text-[9px] font-bold uppercase tracking-[0.22em] text-sol-orange">
                    Personal archive
                </p>

                <span class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted">
                    {{ $showEchoes ? $text_posts_count : $image_posts_count }}
                    {{ $showEchoes ? 'echoes' : 'images' }}
                </span>
            </div>

            @if ($showEchoes)
                <div class="space-y-3">
                    @forelse ($posts as $post)
                        <a
                            href="{{ url('/echoes/'.$post->id) }}" class="block relative bg-sol-paper/55 px-5 py-5 sm:px-7 sm:py-6">
                            <span class="absolute bottom-5 left-0 top-5 w-0.5 bg-sol-orange"></span>

                            <time
                                datetime="{{ $post->created_at->toIso8601String() }}"
                                class="font-body text-[9px] font-semibold uppercase tracking-[0.14em] text-sol-muted"
                            >
                                {{ $post->created_at->diffForHumans() }}
                            </time>

                            <p class="font-display text-lg font-bold leading-7 text-sol-night">
                                {{ \Illuminate\Support\Str::limit($post->content, 100) }}
                            </p>
                        </a>
                    @empty
                        <div class="py-16 text-center">
                            <p class="font-display text-2xl font-bold text-sol-night">
                                No echoes transmitted yet.
                            </p>

                            <a
                                href="{{ url('/text-post/create') }}"
                                class="mt-4 inline-block font-body text-xs font-bold uppercase tracking-[0.16em] text-sol-mars hover:text-sol-orange"
                            >
                                Write the first echo
                            </a>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="grid grid-cols-2 gap-1 sm:gap-2">
                    @forelse ($posts as $post)
                        @php($media = $post->media->first())

                        <a
                            href="{{ url('/sol/'.$post->id) }}"
                            class="group block aspect-square overflow-hidden bg-sol-paper"
                            aria-label="Open Sol {{ $post->id }}"
                        >
                            @if ($media)
                                <img
                                    src="{{ $media->media_uri }}"
                                    alt="{{ $media->media_alt ?: $post->image_title }}"
                                    class="size-full object-cover transition duration-500 group-hover:scale-[1.025]"
                                    loading="lazy"
                                >
                            @else
                                <span
                                    class="grid size-full place-items-center px-5 text-center font-display text-sm font-bold text-sol-muted">
                                    Image transmission unavailable
                                </span>
                            @endif
                        </a>
                    @empty
                        <div class="col-span-2 py-16 text-center">
                            <p class="font-display text-2xl font-bold text-sol-night">
                                No images in this orbit yet.
                            </p>

                            <a
                                href="{{ url('/sol/create') }}"
                                class="mt-4 inline-block font-body text-xs font-bold uppercase tracking-[0.16em] text-sol-mars hover:text-sol-orange"
                            >
                                Publish the first image
                            </a>
                        </div>
                    @endforelse
                </div>
            @endif
        </section>
    </div>
</x-layouts.profile>
