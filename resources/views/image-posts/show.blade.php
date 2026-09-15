<x-layouts.app>
    @php
        $media = $imagePost->media->first();

        $authorName = $imagePost->user->userProfile?->user_name
            ?? $imagePost->user->email;

        $likesCount = $imagePost->likes->count();
        $commentsCount = $imagePost->comments->count();
    @endphp

    <main class="w-full pb-28 pt-8">
        <div class="mx-auto w-full max-w-300 px-4 sm:px-6 lg:px-8">
            {{-- Back link --}}
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
                    <path d="m15 18-6-6 6-6"></path>
                </svg>

                Back to image orbit
            </a>

            <div class="mt-8 grid items-start gap-12 xl:grid-cols-[minmax(0,1fr)_25rem]">
                {{-- Image post --}}
                <article class="min-w-0">
                    <header class="flex items-center justify-between gap-5 px-1 pb-5">
                        <a
                            href="{{ $imagePost->user->profileUrl() }}"
                            class="group flex min-w-0 items-center gap-3"
                        >
                            <x-user.avatar :user="$imagePost->user" />

                            <span class="min-w-0">
                                <span class="block truncate font-display text-lg font-bold text-sol-night transition group-hover:text-sol-mars">
                                    {{ $authorName }}
                                </span>

                                <span class="block font-body text-[9px] font-semibold uppercase tracking-[0.16em] text-sol-muted">
                                    {{ $imagePost->created_at->diffForHumans() }}
                                </span>
                            </span>
                        </a>

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

                    {{-- Actual image --}}
                    <div class="relative overflow-hidden bg-sol-sand">
                        @if ($media)
                            <img
                                src="{{ url($media->media_uri) }}"
                                alt="{{ $media->media_alt ?: $imagePost->image_title }}"
                                class="max-h-[48rem] w-full object-cover"
                            >
                        @else
                            <div class="grid aspect-[4/5] w-full place-items-center bg-sol-sand px-8 text-center">
                                <p class="font-display text-xl font-bold text-sol-mars">
                                    Image transmission unavailable
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="px-1 pt-5">
                        {{-- Statistics --}}
                        <div class="flex items-center gap-7">
                            <button
                                type="button"
                                class="group flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
                                aria-label="{{ $likesCount }} likes"
                            >
                                <svg
                                    class="size-5 text-sol-orange transition group-hover:scale-110"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"></path>
                                </svg>

                                <span>{{ $likesCount }}</span>
                            </button>

                            <a
                                href="#comments"
                                class="group flex items-center gap-2 font-body text-sm font-bold text-sol-night transition hover:text-sol-mars"
                                aria-label="{{ $commentsCount }} comments"
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

                                <span>{{ $commentsCount }}</span>
                            </a>
                        </div>

                        {{-- Title --}}
                        <h1 class="mt-5 max-w-4xl font-display text-2xl font-bold leading-8 text-sol-night sm:text-3xl sm:leading-10">
                            {{ $imagePost->image_title }}
                        </h1>

                        {{-- All tags --}}
                        @if ($imagePost->tags->isNotEmpty())
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($imagePost->tags as $tag)
                                    <span class="bg-sol-paper px-2.5 py-1.5 font-body text-[9px] font-bold uppercase tracking-[0.14em] text-sol-mars">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>

                {{-- Comments panel --}}
                <aside
                    id="comments"
                    class="flex h-[36rem] min-h-0 flex-col xl:sticky xl:top-24 xl:h-[calc(100dvh-10rem)]"
                >
                    <header class="shrink-0 pb-5">
                        <div class="flex items-end justify-between gap-5">
                            <div>
                                <p class="font-body text-[9px] font-bold uppercase tracking-[0.22em] text-sol-mars">
                                    Surface transmissions
                                </p>

                                <h2 class="mt-2 font-display text-3xl font-bold text-sol-night">
                                    Comments
                                </h2>
                            </div>

                            <span class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted">
                                {{ $commentsCount }}
                            </span>
                        </div>

                        <div class="mt-5 h-px w-16 bg-sol-orange"></div>
                    </header>

                    {{-- Only this area scrolls --}}
                    <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain pr-3">
                        @forelse ($imagePost->comments->sortBy('created_at') as $comment)
                            @php
                                $commentAuthor = $comment->user->userProfile?->user_name
                                    ?? $comment->user->email;
                            @endphp

                            <article class="mb-8 last:mb-0">
                                <div class="flex items-start gap-3">
                                    <a
                                        href="{{ $comment->user->profileUrl() }}"
                                        class="shrink-0"
                                        aria-label="Open {{ $commentAuthor }} profile"
                                    >
                                        <x-user.avatar :user="$comment->user" />
                                    </a>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                                            <a
                                                href="{{ $comment->user->profileUrl() }}"
                                                class="truncate font-display text-base font-bold text-sol-night transition hover:text-sol-mars"
                                            >
                                                {{ $commentAuthor }}
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
                        @empty
                            <div class="grid h-full place-items-center py-12 text-center">
                                <div>
                                    <p class="font-display text-xl font-bold text-sol-night">
                                        No transmissions yet
                                    </p>

                                    <p class="mt-2 font-body text-sm text-sol-muted">
                                        Send the first comment from this sol.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Fixed to the bottom of the comments panel --}}
                    <div class="shrink-0 bg-sol-panel pt-5">
                        @auth
                            <form
                                id="comment-form"
                                method="POST"
                                action="{{ url('/sol/'.$imagePost->id.'/comments') }}"
                                class="flex items-end gap-3"
                            >
                                @csrf

                                <div class="min-w-0 flex-1">
                                    <label
                                        for="comment_body"
                                        class="sr-only"
                                    >
                                        Write a comment
                                    </label>

                                    <textarea
                                        id="comment_body"
                                        name="body"
                                        rows="1"
                                        maxlength="500"
                                        required
                                        placeholder="Write a transmission..."
                                        class="block max-h-32 min-h-12 w-full resize-none border-0 border-b border-sol-line bg-transparent px-0 py-3 font-body text-sm text-sol-night outline-none transition placeholder:text-sol-muted focus:border-sol-orange focus:ring-0"
                                    >{{ old('body') }}</textarea>
                                </div>

                                <button
                                    type="submit"
                                    class="grid min-h-12 shrink-0 place-items-center bg-sol-mars px-5 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-panel transition hover:bg-sol-orange"
                                >
                                    Comment
                                </button>
                            </form>

                            @error('body')
                            <p class="mt-2 font-body text-xs font-medium text-sol-mars">
                                {{ $message }}
                            </p>
                            @enderror
                        @else
                            <a
                                href="{{ url('/login') }}"
                                class="flex min-h-12 w-full items-center justify-center bg-sol-night px-5 font-body text-[9px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:bg-sol-mars"
                            >
                                Log in to comment
                            </a>
                        @endauth
                    </div>
                </aside>
            </div>
        </div>
    </main>
</x-layouts.app>
