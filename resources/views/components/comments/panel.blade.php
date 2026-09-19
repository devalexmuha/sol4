@props([
    'endpoint',           // GET (list) + POST (create) : /sol|echoes/{id}/comments
    'base' => null,       // PATCH/DELETE base for a comment
])

@php
    $base ??= url('/comments');
@endphp

<aside
    id="comments"
    data-comments
    data-endpoint="{{ $endpoint }}"
    data-base="{{ $base }}"
    class="flex h-[32rem] min-h-0 flex-col xl:sticky xl:top-24 xl:h-[calc(100dvh-10rem)]"
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

            <span
                class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                data-comments-count
            >0</span>
        </div>

        <div class="mt-5 h-px w-16 bg-sol-orange"></div>
    </header>

    {{-- JS renders the spinner + comments here. --}}
    <div
        data-comments-list
        class="min-h-0 flex-1 overflow-y-auto overscroll-contain pr-3"
    ></div>

    {{-- Composer: only for authenticated users (task 6). --}}
    <div class="shrink-0 bg-sol-panel pt-5">
        @auth
            <form data-comment-form class="flex items-end gap-3">
                @csrf
                <div class="min-w-0 flex-1">
                    <label for="comment_body" class="sr-only">Write a comment</label>
                    <textarea
                        id="comment_body"
                        name="body"
                        rows="1"
                        maxlength="1000"
                        required
                        placeholder="Write a transmission..."
                        class="block max-h-32 min-h-12 w-full resize-none border-0 border-b border-sol-line bg-transparent px-0 py-3 font-body text-sm text-sol-night outline-none transition placeholder:text-sol-muted focus:border-sol-orange focus:ring-0"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="grid min-h-12 shrink-0 place-items-center bg-sol-mars px-5 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-panel transition hover:bg-sol-orange disabled:opacity-60"
                >
                    Comment
                </button>
            </form>
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
