<x-layouts.app>
    <section class="mx-auto w-full max-w-300 pb-28 pt-10 sm:pt-16">
        <header class="flex items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <span class="h-px w-10 bg-sol-orange"></span>

                    <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                        New transmission
                    </p>
                </div>

                <h1 class="mt-4 font-display text-3xl font-bold text-sol-night sm:text-4xl">
                    Create image post
                </h1>
            </div>

            <a
                href="{{ url('/') }}"
                class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars"
            >
                Cancel
            </a>
        </header>
        <x-forms.error class="mt-6" />
        <form
            method="POST"
            action="{{ url('/sol') }}"
            enctype="multipart/form-data"
            class="mt-12"
        >
            @csrf

            {{-- Image --}}
            <div>
                <div class="flex items-center justify-between gap-4">
                    <label
                        for="image"
                        class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night"
                    >
                        Image
                    </label>

                    <span class="font-body text-[9px] uppercase tracking-[0.16em] text-sol-muted">
                        JPG, PNG or WebP
                    </span>
                </div>

                <input
                    id="image"
                    name="image"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    required
                    class="mt-4 block w-full bg-sol-paper font-body text-sm text-sol-muted
                           file:mr-5 file:border-0 file:bg-sol-night file:px-5 file:py-4
                           file:font-body file:text-[10px] file:font-bold file:uppercase
                           file:tracking-[0.18em] file:text-sol-panel
                           hover:file:bg-sol-mars"
                >
            </div>

            {{-- Title --}}
            <div class="mt-10">
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
                    value="{{ old('image_title') }}"
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
                    @forelse ($tags as $tag)
                        <label class="group cursor-pointer">
                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                class="peer sr-only"
                                @checked(in_array(
                                    (string) $tag->id,
                                    array_map('strval', old('tags', [])),
                                    true
                                ))
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

            <div class="mt-14 flex justify-end">
                <button
                    type="submit"
                    class="min-h-12 w-full bg-sol-mars px-8 font-body text-[10px]
                           font-bold uppercase tracking-[0.2em] text-sol-panel
                           transition hover:bg-sol-orange sm:w-auto"
                >
                    Publish transmission
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
