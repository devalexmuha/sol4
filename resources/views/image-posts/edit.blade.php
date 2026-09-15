<x-layouts.app>
    @php
        $media = $imagePost->media->first();

        $allTags = \App\Models\Tag::orderBy('name')->get();

        $selectedTags = old('tags', $imagePost->tags->pluck('id')->all());
        $selectedTags = array_map('strval', $selectedTags);
    @endphp

    <section class="mx-auto w-full max-w-300 pb-28 pt-10 sm:pt-16">
        <header class="flex items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <span class="h-px w-10 bg-sol-orange"></span>

                    <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                        Edit transmission
                    </p>
                </div>

                <h1 class="mt-4 font-display text-3xl font-bold text-sol-night sm:text-4xl">
                    Edit image post
                </h1>
            </div>

            <a
                href="{{ url('/sol/'.$imagePost->id) }}"
                class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars"
            >
                Cancel
            </a>
        </header>

        <x-forms.error class="mt-6"/>

        <div class="mt-12 grid gap-12 lg:grid-cols-[22rem_minmax(0,1fr)] lg:gap-16">
            {{-- Current image (read-only) --}}
            <div>
                <p class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night">
                    Current image
                </p>

                <div class="mt-4 overflow-hidden bg-sol-sand">
                    @if ($media)
                        <img
                            src="{{ url($media->media_uri) }}"
                            alt="{{ $media->media_alt ?: $imagePost->image_title }}"
                            class="w-full object-cover"
                        >
                    @else
                        <div class="grid aspect-[4/5] w-full place-items-center px-8 text-center">
                            <p class="font-display text-lg font-bold text-sol-mars">
                                Image transmission unavailable
                            </p>
                        </div>
                    @endif
                </div>

                <p class="mt-3 font-body text-xs leading-5 text-sol-muted">
                    The image cannot be changed after publishing.
                </p>
            </div>

            {{-- Editable fields --}}
            <form
                id="edit-form"
                method="POST"
                action="{{ url('/sol/'.$imagePost->id) }}"
            >
                @csrf
                @method('PATCH')

                {{-- Title --}}
                <div>
                    <div class="flex items-center justify-between gap-4">
                        <label
                            for="image_title"
                            class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night"
                        >
                            Title
                        </label>

                        <span class="font-body text-[9px] uppercase tracking-[0.16em] text-sol-muted">
                            255 characters
                        </span>
                    </div>

                    <input
                        id="image_title"
                        name="image_title"
                        type="text"
                        value="{{ old('image_title', $imagePost->image_title) }}"
                        maxlength="255"
                        required
                        placeholder="Write a title for this transmission"
                        class="mt-4 block w-full border-0 border-b border-sol-line bg-transparent
                               px-0 py-4 font-display text-xl font-bold text-sol-night
                               outline-none placeholder:font-normal placeholder:text-sol-muted
                               focus:border-sol-orange focus:ring-0"
                    >
                </div>

                {{-- Tags --}}
                <fieldset class="mt-10">
                    <div class="flex items-center justify-between gap-4">
                        <legend class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night">
                            Tags
                        </legend>

                        <span class="font-body text-[9px] uppercase tracking-[0.16em] text-sol-muted">
                            Select multiple
                        </span>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-x-6 gap-y-4">
                        @forelse ($allTags as $tag)
                            <label class="group cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    class="peer sr-only"
                                    @checked(in_array((string) $tag->id, $selectedTags, true))
                                >

                                <span
                                    class="block border-b border-sol-line px-1 py-2
                                           font-body text-[10px] font-bold uppercase
                                           tracking-[0.14em] text-sol-muted transition
                                           group-hover:border-sol-orange group-hover:text-sol-mars
                                           peer-checked:border-sol-orange
                                           peer-checked:text-sol-mars"
                                >
                                    #{{ $tag->name }}
                                </span>
                            </label>
                        @empty
                            <p class="font-body text-sm text-sol-muted">
                                No tags are available.
                            </p>
                        @endforelse
                    </div>
                </fieldset>
            </form>
        </div>

        {{-- Actions --}}
        <div
            class="mt-14 flex flex-col gap-4 border-t border-sol-line pt-8 sm:flex-row sm:items-center sm:justify-between">
            {{-- Delete (separate form) --}}
            <form
                method="POST"
                action="{{ url('/sol/'.$imagePost->id) }}"
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
