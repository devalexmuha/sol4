@props([
    'comments',
    'action',
])

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
                {{ $comments->count() }}
            </span>
        </div>

        <div class="mt-5 h-px w-16 bg-sol-orange"></div>
    </header>

    {{-- Only this area scrolls --}}
    <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain pr-3">
        @forelse ($comments->sortBy('created_at') as $comment)
            <x-comments.item :comment="$comment" />
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
                action="{{ $action }}"
                class="flex items-end gap-3"
            >
                @csrf

                <div class="min-w-0 flex-1">
                    <label for="comment_body" class="sr-only">
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
