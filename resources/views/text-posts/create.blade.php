<x-layouts.app title="New echo · SOL4">
    <section class="mx-auto w-full max-w-300 pb-28 pt-10 sm:pt-16">
        <x-post.form-header
            eyebrow="New transmission"
            title="Create text post"
            :cancel="url('/echoes')"
        />

        <x-forms.error class="mt-6" />

        <form method="POST" action="{{ url('/echoes') }}" class="mt-12">
            @csrf

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
                >{{ old('content') }}</textarea>
            </div>

            {{-- Tags --}}
            <x-post.tag-picker :tags="$tags" :selected="old('tags', [])" class="mt-10" />

            <div class="mt-14 flex justify-end">
                <button
                    type="submit"
                    class="min-h-12 w-full bg-sol-mars px-8 font-body text-[10px]
                           font-bold uppercase tracking-[0.2em] text-sol-panel
                           transition hover:bg-sol-orange sm:w-auto"
                >
                    Publish echo
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
