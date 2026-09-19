@php
    $avatar = $userProfile->media->first();
@endphp

<x-layouts.app title="Edit profile">
    <div class="mx-auto w-full max-w-300 px-4 pb-16 pt-7 sm:px-6 sm:pt-10 lg:px-8">
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

        <span>Return to my profile</span>
        </a>

        <header class="mt-12 sm:mt-16">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="h-px w-10 bg-sol-orange"></span>

                    <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                        Edit profile
                    </p>
                </div>

                <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                    {{ $userProfile->user->email }}
                </p>
            </div>
        </header>

        @if (session('status'))
            <div class="mt-10 bg-sol-sand/45 px-5 py-4 font-body text-sm font-medium text-sol-mars">
                {{ session('status') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ url('/profiles/'.$userProfile->user_name) }}"
            enctype="multipart/form-data"
            class="mt-14"
        >
            @csrf
            @method('PATCH')

            <div class="grid gap-14 lg:grid-cols-[16rem_minmax(0,1fr)] lg:gap-24">
                <section>
                    <p class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-muted">
                        Profile image
                    </p>

                    <div id="avatar-preview" class="mt-5">
                        @if ($avatar)
                            <img
                                src="{{ url($avatar->media_uri) }}"
                                alt="{{ $avatar->media_alt ?: $userProfile->user_name.' profile image' }}"
                                class="size-36 rounded-full object-cover"
                            >
                        @else
                            <div
                                class="grid size-36 place-items-center rounded-full bg-sol-night font-display text-4xl font-bold uppercase text-sol-sand">
                                {{ mb_substr($userProfile->user_name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <label
                        for="logo"
                        class="mt-7 block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                    >
                        Upload new image
                    </label>

                    <input
                        id="logo"
                        name="logo"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        data-image-preview
                        data-preview-target="#avatar-preview"
                        data-preview-img-class="size-36 rounded-full object-cover"
                        data-preview-filename="#logo-filename"
                        class="mt-3 block w-full font-body text-xs text-sol-muted file:mr-4 file:border-0 file:bg-sol-paper file:px-4 file:py-3 file:font-body file:text-[10px] file:font-bold file:uppercase file:tracking-[0.14em] file:text-sol-mars hover:file:bg-sol-sand/60"
                    >

                    <p id="logo-filename" class="mt-2 truncate font-body text-xs text-sol-mars"></p>

                    <p class="mt-3 font-body text-xs leading-5 text-sol-muted">
                        JPG, PNG or WEBP. Maximum 2 MB.
                    </p>

                    @error('logo')
                    <p class="mt-2 font-body text-xs font-medium text-sol-mars">
                        {{ $message }}
                    </p>
                    @enderror
                </section>

                <section class="space-y-10">
                    <div>
                        <label
                            for="user_name"
                            class="mb-2 block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                        >
                            User name
                        </label>

                        <input
                            id="user_name"
                            name="user_name"
                            type="text"
                            value="{{ old('user_name', $userProfile->user_name) }}"
                            maxlength="50"
                            autocomplete="username"
                            required
                            class="block w-full border-0 border-b border-sol-line bg-transparent px-0 py-3 font-display text-xl font-bold text-sol-night outline-none transition focus:border-sol-orange focus:ring-0"
                        >

                        @error('user_name')
                        <p class="mt-2 font-body text-xs font-medium text-sol-mars">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-4">
                            <label
                                for="user_bio"
                                class="font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                            >
                                Biography
                            </label>

                            <span class="font-body text-[9px] uppercase tracking-[0.14em] text-sol-muted">
                                500 characters
                            </span>
                        </div>

                        <textarea
                            id="user_bio"
                            name="user_bio"
                            rows="6"
                            maxlength="500"
                            class="block w-full resize-y border-0 border-b border-sol-line bg-transparent px-0 py-3 font-body text-sm leading-7 text-sol-ink outline-none transition focus:border-sol-orange focus:ring-0"
                            placeholder="Write something about yourself..."
                        >{{ old('user_bio', $userProfile->user_bio) }}</textarea>

                        @error('user_bio')
                        <p class="mt-2 font-body text-xs font-medium text-sol-mars">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="flex min-h-13 items-center gap-12 bg-sol-mars px-6 font-body text-xs font-bold uppercase tracking-[0.2em] text-sol-panel transition hover:bg-sol-orange"
                        >
                            <span>Save changes</span>

                            <svg
                                class="size-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                                aria-hidden="true"
                            >
                                <path d="m5 12 4 4L19 6"></path>
                            </svg>
                        </button>
                    </div>
                </section>
            </div>
        </form>

        <section class="mt-20 px-5 py-5 sm:px-6">
            <div class="flex items-center justify-between gap-6">
                <div>
                    <p class="font-body text-[9px] font-bold uppercase tracking-[0.2em] text-sol-amber">
                        Session
                    </p>

                    <p class="mt-1 font-body text-sm text-sol-muted">
                        Sign out from this device.
                    </p>
                </div>

                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="min-h-12 w-48 bg-sol-night px-5 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:bg-sol-mars"
                    >
                        Log out
                    </button>
                </form>
            </div>
        </section>

        <section class="mt-6 px-5 py-6 sm:px-6">
            <div class="grid gap-6 sm:grid-cols-[minmax(0,1fr)_20rem] sm:items-end">
                <div>
                    <p class="font-body text-[9px] font-bold uppercase tracking-[0.2em] text-sol-mars">
                        Danger zone
                    </p>

                    <p class="mt-2 max-w-lg font-body text-sm leading-6 text-sol-muted">
                        Permanently delete your account and all associated data.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ url('/profiles/'.$userProfile->user_name) }}"
                    onsubmit="return confirm('Delete your SOL4 account permanently?')"
                    class="flex flex-col items-end"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="mt-4 min-h-12 w-48 bg-sol-mars px-5 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:bg-sol-orange"
                    >
                        Delete account
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-layouts.app>
