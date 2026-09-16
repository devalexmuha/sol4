<x-layouts.app title="Explorers · SOL4">
    @php
        $search = request()->query('search', '');
    @endphp

    {{-- Search bar --}}
    <section class="mx-auto w-full max-w-300">
        <div class="flex items-center gap-3">
            <span class="h-px w-10 bg-sol-orange"></span>

            <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                Find explorers
            </p>
        </div>

        <form method="GET" action="{{ url('/users') }}" class="mt-5">
            <div class="flex items-center gap-3 border-b border-sol-line focus-within:border-sol-orange">
                <svg
                    class="size-5 shrink-0 text-sol-muted"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    aria-hidden="true"
                >
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-3.5-3.5"></path>
                </svg>

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    autocomplete="off"
                    placeholder="Search by name..."
                    class="min-w-0 flex-1 border-0 bg-transparent px-0 py-4 font-display text-xl font-bold text-sol-night outline-none placeholder:font-normal placeholder:text-sol-muted focus:ring-0"
                >

                @if ($search !== '')
                    <a
                        href="{{ url('/users') }}"
                        class="shrink-0 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted transition hover:text-sol-mars"
                    >
                        Clear
                    </a>
                @endif

                <button
                    type="submit"
                    class="shrink-0 bg-sol-mars px-5 py-2.5 font-body text-[9px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:bg-sol-orange"
                >
                    Search
                </button>
            </div>
        </form>

        @if ($search !== '')
            <p class="mt-4 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted">
                Results for &ldquo;{{ $search }}&rdquo; · {{ $users->count() }}
            </p>
        @endif
    </section>

    {{-- Results --}}
    <section class="mx-auto mt-10 w-full max-w-300">
        @forelse ($users as $user)
            @php
                $name = $user->userProfile?->user_name ?? $user->email;
                $bio = $user->userProfile?->user_bio;
            @endphp

            <a
                href="{{ url('/users/'.$user->id) }}"
                class="group flex items-center gap-4 border-b border-sol-line py-5 transition first:border-t hover:bg-sol-paper/50"
            >
                <x-user.avatar :user="$user" size="lg" />

                <div class="min-w-0 flex-1">
                    <div class="flex items-baseline justify-between gap-4">
                        <span class="truncate font-display text-lg font-bold text-sol-night transition group-hover:text-sol-mars">
                            {{ $name }}
                        </span>

                        <span class="shrink-0 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                            {{ $user->subscribers_count }} subs
                        </span>
                    </div>

                    @if ($bio)
                        <p class="mt-1 truncate font-body text-sm text-sol-muted">
                            {{ \Illuminate\Support\Str::limit($bio, 100) }}
                        </p>
                    @endif
                </div>

                <svg
                    class="size-5 shrink-0 text-sol-muted transition group-hover:translate-x-1 group-hover:text-sol-mars"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </a>
        @empty
            <div class="w-full rounded-sol border border-dashed border-sol-line bg-sol-panel p-10 text-center">
                <span class="mb-3 block font-body text-[10px] font-bold uppercase tracking-[0.22em] text-sol-mars">
                    {{ $search !== '' ? 'No signals' : 'Search the orbit' }}
                </span>

                <h2 class="font-display text-2xl font-bold text-sol-night">
                    {{ $search !== '' ? 'No explorers found' : 'Look for an explorer' }}
                </h2>

                <p class="mt-2 font-body text-sm text-sol-muted">
                    {{ $search !== ''
                        ? 'Try a different name.'
                        : 'Type a name above to find people on SOL4.' }}
                </p>
            </div>
        @endforelse
    </section>
</x-layouts.app>
