<x-layouts.app :title="($userProfile->user_name).' · SOL4'">
    @php
        $user = $userProfile->user;

        $avatar = $userProfile->media->first();
        $name = $userProfile->user_name;
        $bio = $userProfile->user_bio;

        $postType = request()->query('post_type', 'images');
        $showEchoes = $postType === 'echoes';

        $base = url('/profiles/'. $name);
    @endphp
    <div class="mx-auto w-full max-w-300">
        {{-- Back link --}}
        <a
        href="{{ url('/profiles') }}"
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

        <span>Back to explorers</span>
        </a>

        {{-- Identity --}}
        <section class="mt-10 sm:mt-14">
            <div class="grid items-start gap-8 sm:grid-cols-[9rem_minmax(0,1fr)] sm:gap-12">
                <div class="w-fit">
                    @if ($avatar)
                        <img
                            src="{{ url($avatar->media_uri) }}"
                            alt="{{ $avatar->media_alt ?: $name.' profile image' }}"
                            class="size-28 rounded-full object-cover sm:size-36"
                        >
                    @else
                        <div
                            class="grid size-28 place-items-center rounded-full bg-sol-night font-display text-4xl font-bold uppercase text-sol-sand sm:size-36">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-4">
                        <h1 class="truncate font-display text-3xl font-bold text-sol-night sm:text-4xl">
                            {{ $name }}
                        </h1>

                        <span class="h-px min-w-8 flex-1 bg-sol-orange"></span>
                        @can('modify', $userProfile)
                            <a
                            href="{{ $base.'/edit' }}"
                            class="group grid size-9 shrink-0 place-items-center rounded-full text-sol-muted transition hover:bg-sol-paper hover:text-sol-mars"
                            aria-label="Edit profile"
                            title="Edit profile"
                            >
                            <svg class="size-5 transition group-hover:rotate-45" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"></path>
                            </svg>
                            </a>
                        @endcan
                    </div>

                    @if ($bio)
                        <p class="mt-5 max-w-2xl font-body text-sm leading-7 text-sol-muted">
                            {{ $bio }}
                        </p>
                    @endif

                    <div class="mt-8 grid max-w-lg grid-cols-3 gap-6">
                        <div>
                            <span class="block font-display text-2xl font-bold text-sol-night">
                                {{ $user->image_posts_count + $user->text_posts_count }}
                            </span>
                            <span class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                                Signals
                            </span>
                        </div>

                        <a href="{{ $base.'/subscribers' }}" class="group block transition hover:text-sol-mars">
                            <span id="subscribers-count" class="block font-display text-2xl font-bold text-sol-night transition group-hover:text-sol-mars" id="subscribers-count">
                                {{ $user->subscribers_count }}
                            </span>
                            <span class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted transition group-hover:text-sol-mars">
                                Subscribers
                            </span>
                        </a>

                        <a href="{{ $base.'/subscriptions' }}" class="group block transition hover:text-sol-mars">
                            <span class="block font-display text-2xl font-bold text-sol-night transition group-hover:text-sol-mars">
                                {{ $user->subscribed_to_count }}
                            </span>
                            <span class="mt-1 block font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted transition group-hover:text-sol-mars">
                                Subscriptions
                            </span>
                        </a>
                    </div>

                    {{-- Subscribe --}}
                    @auth
                        @unless ($isMine)
                            <div class="mt-6">
                                <button
                                    id="subscribe-btn"
                                    type="button"
                                    data-endpoint="{{ $base.'/subscribers' }}"
                                    data-subscribed="{{ $isSubscribed ? 'true' : 'false' }}"
                                    data-csrf="{{ csrf_token() }}"
                                    aria-pressed="{{ $isSubscribed ? 'true' : 'false' }}"
                                    class="{{ $isSubscribed
                                        ? 'border border-sol-line bg-sol-paper text-sol-muted hover:border-sol-mars hover:text-sol-mars'
                                        : 'bg-sol-orange text-sol-panel hover:bg-sol-mars'
                                    }} inline-flex min-h-11 items-center gap-2 rounded-sol px-14 font-body text-[10px] font-bold uppercase tracking-[0.18em] transition"
                                >
                                    <span data-subscribe-label>
                                        {{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}
                                    </span>
                                </button>
                            </div>
                        @endunless
                    @endauth
                </div>
            </div>
        </section>

        {{-- Switcher: images / echoes --}}
        <section class="mt-14">
            <div class="grid grid-cols-2 border-b border-sol-line">
                <a
                href="{{ $base }}"
                class="{{ ! $showEchoes
                        ? 'border-sol-orange text-sol-mars'
                        : 'border-transparent text-sol-muted hover:text-sol-mars'
                    }} group flex min-h-14 items-center justify-center gap-2 border-b-2 font-body transition"
                @if(! $showEchoes) aria-current="page" @endif
                >
                <svg class="size-5" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5"
                     aria-hidden="true">
                    <rect x="3.5" y="5.5" width="21" height="16"></rect>
                    <circle cx="9" cy="10.5" r="1.5"></circle>
                    <path d="m5.5 19 4.5-4.5 3 3 2.5-2.5 6 6"></path>
                </svg>

                <span class="text-[10px] font-bold uppercase tracking-[0.18em]">
                        Images · {{ $user->image_posts_count }}
                    </span>
                </a>
                <a

                href="{{ $base }}?post_type=echoes"
                class="{{ $showEchoes
                        ? 'border-sol-orange text-sol-mars'
                        : 'border-transparent text-sol-muted hover:text-sol-mars'
                    }} group flex min-h-14 items-center justify-center gap-2 border-b-2 font-body transition"
                @if($showEchoes) aria-current="page" @endif
                >
                <svg class="size-5" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5"
                     aria-hidden="true">
                    <path d="M4 7.5h11M4 12h9M4 16.5h7"></path>
                    <path d="m14.5 21 1-4 7.5-7.5 3 3-7.5 7.5-4 1Z"></path>
                    <path d="m21.5 11 3 3"></path>
                </svg>

                <span class="text-[10px] font-bold uppercase tracking-[0.18em]">
                        Echoes · {{ $user->text_posts_count }}
                    </span>
                </a>
            </div>
        </section>

        {{-- Posts --}}
        <section class="mt-8">
            @if ($showEchoes)
                <div class="space-y-3">
                    @forelse ($posts as $post)
                        <a
                        href="{{ url('/echoes/'.$post->id) }}"
                        class="relative block bg-sol-paper/55 px-5 py-5 sm:px-7 sm:py-6"
                        >
                        <span class="absolute bottom-5 left-0 top-5 w-0.5 bg-sol-orange"></span>

                        <time
                            datetime="{{ $post->created_at->toIso8601String() }}"
                            class="font-body text-[9px] font-semibold uppercase tracking-[0.14em] text-sol-muted"
                        >
                            {{ $post->created_at->diffForHumans() }}
                        </time>

                        <p class="mt-1 font-display text-lg font-bold leading-7 text-sol-night">
                            {{ \Illuminate\Support\Str::limit($post->content, 140) }}
                        </p>
                        </a>
                    @empty
                        <div class="py-16 text-center">
                            <p class="font-display text-2xl font-bold text-sol-night">
                                No echoes yet.
                            </p>
                            <p class="mt-2 font-body text-sm text-sol-muted">
                                {{ $name }} hasn't transmitted any echoes.
                            </p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="grid grid-cols-2 gap-1 sm:grid-cols-3 sm:gap-2">
                    @forelse ($posts as $post)
                        @php($media = $post->media->first())

                        <a
                        href="{{ url('/sol/'.$post->id) }}"
                        class="group block aspect-square overflow-hidden bg-sol-paper"
                        aria-label="Open Sol {{ $post->id }}"
                        >
                        @if ($media)
                            <img
                                src="{{ url($media->media_uri) }}"
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
                                <div class="col-span-2 py-16 text-center sm:col-span-3">
                                    <p class="font-display text-2xl font-bold text-sol-night">
                                        No images yet.
                                    </p>
                                    <p class="mt-2 font-body text-sm text-sol-muted">
                                        {{ $name }} hasn't published any images.
                                    </p>
                                </div>
                            @endforelse
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
