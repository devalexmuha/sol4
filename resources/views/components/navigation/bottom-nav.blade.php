@php
    $orbitActive = request()->is('/');
    $echoesActive = request()->is('echoes*');
    $authenticated = auth()->check();
@endphp

<nav
    class="safe-bottom fixed inset-x-0 bottom-0 z-50 w-full bg-sol-panel/95 backdrop-blur"
    aria-label="Primary navigation"
>
    <div
        class="{{ $authenticated ? 'grid-cols-3' : 'grid-cols-2' }} mx-auto grid w-full max-w-300 px-4 sm:px-6 lg:px-8"
    >
        {{-- Image posts --}}
        <a
            href="{{ url('/') }}"
            class="{{ $orbitActive
                ? 'border-sol-orange text-sol-mars'
                : 'border-transparent text-sol-muted hover:text-sol-mars'
            }} group flex min-h-16 flex-col items-center justify-center gap-1 border-t-2 font-body transition"
            @if($orbitActive) aria-current="page" @endif
        >
            <svg
                class="size-7 transition group-hover:-translate-y-0.5"
                viewBox="0 0 28 28"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
            >
                <rect x="3.5" y="5.5" width="21" height="16"></rect>
                <circle cx="9" cy="10.5" r="1.5"></circle>
                <path d="m5.5 19 4.5-4.5 3 3 2.5-2.5 6 6"></path>
            </svg>

            <span class="text-[9px] font-bold uppercase tracking-[0.18em]">
                Orbit
            </span>
        </a>

        {{-- Creation controls for authenticated users --}}
        @auth
            <div class="grid min-h-16 grid-cols-2 border-x border-sol-line">
                <a
                    href="{{ url('/image-post/create') }}"
                    class="{{ request()->is('image-post/create')
                        ? 'border-sol-orange bg-sol-paper text-sol-mars'
                        : 'border-transparent text-sol-muted hover:bg-sol-paper hover:text-sol-orange'
                    }} group relative grid place-items-center border-t-2 transition"
                    @if(request()->is('image-post/create')) aria-current="page" @endif
                    aria-label="Create image post"
                    title="Create image post"
                >
                    <svg
                        class="size-7 transition group-hover:-translate-y-0.5"
                        viewBox="0 0 28 28"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        aria-hidden="true"
                    >
                        <rect x="3.5" y="5.5" width="17" height="16"></rect>
                        <circle cx="9" cy="10.5" r="1.5"></circle>
                        <path d="m5.5 19 4.5-4.5 3 3 2.5-2.5 3 3"></path>
                        <path d="M23 3.5v7M19.5 7h7"></path>
                    </svg>

                    <span
                        class="absolute bottom-2 size-1 bg-sol-orange opacity-0 transition group-hover:opacity-100"
                        aria-hidden="true"
                    ></span>
                </a>

                <a
                    href="{{ url('/text-post/create') }}"
                    class="{{ request()->is('text-post/create')
                        ? 'border-sol-orange bg-sol-paper text-sol-mars'
                        : 'border-transparent text-sol-muted hover:bg-sol-paper hover:text-sol-orange'
                    }} group relative grid place-items-center border-l border-t-2 border-l-sol-line transition"
                    @if(request()->is('text-post/create')) aria-current="page" @endif
                    aria-label="Create text post"
                    title="Create text post"
                >
                    <svg
                        class="size-7 transition group-hover:-translate-y-0.5"
                        viewBox="0 0 28 28"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        aria-hidden="true"
                    >
                        <path d="M4 7.5h11M4 12h9M4 16.5h7"></path>
                        <path d="m14.5 21 1-4 7.5-7.5 3 3-7.5 7.5-4 1Z"></path>
                        <path d="m21.5 11 3 3"></path>
                    </svg>

                    <span
                        class="absolute bottom-2 size-1 bg-sol-orange opacity-0 transition group-hover:opacity-100"
                        aria-hidden="true"
                    ></span>
                </a>
            </div>
        @endauth

        {{-- Text posts --}}
        <a
            href="{{ url('/echoes') }}"
            class="{{ $echoesActive
                ? 'border-sol-orange text-sol-mars'
                : 'border-transparent text-sol-muted hover:text-sol-mars'
            }} group flex min-h-16 flex-col items-center justify-center gap-1 border-t-2 font-body transition"
            @if($echoesActive) aria-current="page" @endif
        >
            <svg
                class="size-7 transition group-hover:-translate-y-0.5"
                viewBox="0 0 28 28"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
            >
                <path d="M4 7.5h11M4 12h9M4 16.5h7"></path>
                <path d="m14.5 21 1-4 7.5-7.5 3 3-7.5 7.5-4 1Z"></path>
                <path d="m21.5 11 3 3"></path>
            </svg>

            <span class="text-[9px] font-bold uppercase tracking-[0.18em]">
                Echoes
            </span>
        </a>
    </div>
</nav>
