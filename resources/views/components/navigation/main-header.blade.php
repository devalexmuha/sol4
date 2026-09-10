@php
    $profileActive = request()->is('profile*');
@endphp

<header class="fixed top-0 z-40 w-full bg-sol-panel/95 backdrop-blur">
    <div class="mx-auto flex h-16 w-full max-w-300 items-center justify-between px-4 sm:px-6 lg:px-8">
        <a
            href="{{ url('/') }}"
            class="group flex items-center gap-3"
            aria-label="SOL4 home"
        >
            <span class="relative grid size-10 place-items-center overflow-hidden rounded-sol bg-sol-night">
                <span
                    class="size-5 rounded-full border border-orange-300 bg-sol-orange shadow-[inset_-4px_-3px_0_rgba(88,32,19,0.35)]"
                ></span>

                <span class="absolute bottom-1 right-1 font-body text-[8px] font-black tracking-wider text-sol-sand">
                    04
                </span>
            </span>
        </a>

        @php
            $profileActive = request()->is('profile*');
        @endphp

        <div class="flex items-center gap-2">
            @auth
                @php
                    $headerUser = auth()->user();
                    $headerName = $headerUser->userProfile?->user_name
                        ?: $headerUser->name;
                @endphp

                <a
                    href="{{ url('/profile') }}"
                    class="{{ $profileActive
                ? 'border-sol-orange bg-sol-paper text-sol-mars'
                : 'border-sol-line text-sol-muted hover:border-sol-orange hover:text-sol-mars'
            }} flex h-11 min-w-0 items-center gap-2 border px-2.5 transition"
                    @if ($profileActive) aria-current="page" @endif
                    aria-label="Open profile"
                >
                    <x-user.avatar :user="$headerUser" size="sm" />

                    <span class="hidden max-w-32 truncate font-display text-sm font-bold text-sol-night sm:block">
                {{ $headerName }}
            </span>
                </a>
            @else
                <a
                    href="{{ url('/login') }}"
                    class="flex h-10 items-center gap-2 border border-sol-line px-3 text-sol-muted transition hover:border-sol-orange hover:text-sol-mars"
                    aria-label="Log in"
                >
                    <svg
                        class="size-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        aria-hidden="true"
                    >
                        <circle cx="12" cy="8" r="3.5"></circle>
                        <path d="M5 20c.7-4 3.1-6 7-6s6.3 2 7 6"></path>
                    </svg>

                    <span class="font-body text-[10px] font-bold uppercase tracking-[0.16em]">
                Log in
            </span>
                </a>

                <a
                    href="{{ url('/register') }}"
                    class="flex h-10 items-center border border-sol-mars bg-sol-mars px-3 font-body text-[10px] font-bold uppercase tracking-[0.16em] text-sol-panel transition hover:border-sol-orange hover:bg-sol-orange"
                >
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>
