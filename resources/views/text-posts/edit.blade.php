<x-layouts.app title="Edit echo · SOL4">
    <section class="mx-auto w-full max-w-300 pb-28 pt-10 sm:pt-16">
        <x-post.form-header
            eyebrow="Edit transmission"
            title="Edit text post"
            :cancel="url('/echoes/'.$textPost->id)"
        />

        <x-forms.error class="mt-6" />

        {{-- Editable fields --}}
        <form id="edit-form" method="POST" action="{{ url('/echoes/'.$textPost->id) }}" class="mt-12">
            @csrf
            @method('PATCH')

            {{-- Content --}}
            <div>
                <div class="flex items-center justify-between gap-4">
                    <label
                        for="content"
                        class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night"
                    >
                        Echo
                    </label>

                    <span class="font-body text-[9px] uppercase tracking-[0.16em] text-sol-muted">
                        500 characters
                    </span>
                </div>

                <textarea
                    id="content"
                    name="content"
                    rows="6"
                    maxlength="500"
                    required
                    placeholder="Transmit your echo..."
                    class="mt-4 block w-full resize-y border-0 border-b border-sol-line bg-transparent
                           px-0 py-4 font-display text-xl font-bold leading-8 text-sol-night
                           outline-none placeholder:font-normal placeholder:text-sol-muted
                           focus:border-sol-orange focus:ring-0"
                >{{ old('content', $textPost->content) }}</textarea>
            </div>

            {{-- Tags --}}
            <x-post.tag-picker
                :tags="$tags"
                :selected="old('tags', $textPost->tags->pluck('id')->all())"
                class="mt-10"
            />
        </form>

        {{-- Actions --}}
        <div class="mt-14 flex flex-col gap-4 border-t border-sol-line pt-8 sm:flex-row sm:items-center sm:justify-between">
            {{-- Delete (separate form) --}}
            <form
                method="POST"
                action="{{ url('/echoes/'.$textPost->id) }}"
                onsubmit="return confirm('Delete this transmission permanently?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="min-h-12 w-full bg-sol-night px-8 font-body text-[10px]
                           font-bold uppercase tracking-[0.2em] text-sol-panel
                           transition hover:bg-sol-mars sm:w-auto"
                >
                    Delete post
                </button>
            </form>

            {{-- Save (submits the edit form above) --}}
            <button
                type="submit"
                form="edit-form"
                class="min-h-12 w-full bg-sol-mars px-8 font-body text-[10px]
                       font-bold uppercase tracking-[0.2em] text-sol-panel
                       transition hover:bg-sol-orange sm:w-auto"
            >
                Save changes
            </button>
        </div>
    </section>
</x-layouts.app>
