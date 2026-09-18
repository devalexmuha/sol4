<x-layouts.app :title="$userName.' · Subscriptions · SOL4'">
    {{-- Heading --}}
    <section class="mx-auto w-full max-w-300">
        <div class="flex items-center gap-3">
            <span class="h-px w-10 bg-sol-orange"></span>

            <p class="font-body text-[10px] font-bold uppercase tracking-[0.24em] text-sol-mars">
                Subscriptions
            </p>
        </div>

        <h1 class="mt-4 font-display text-2xl font-bold text-sol-night sm:text-3xl">
            {{ $userName }} subscriptions
        </h1>

        <p class="mt-2 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted">
            {{ $subscriptions->count() }} explorers
        </p>
    </section>

    {{-- List --}}
    <section class="mx-auto mt-10 w-full max-w-300">
        @forelse ($subscriptions as $subscription)
            @php
                $name = $subscription->userProfile?->user_name ?? $subscription->email;
                $bio = $subscription->userProfile?->user_bio;
            @endphp

            <a
            href="{{ url('/profiles/' . $subscription->displayName()) }}"
            class="group flex items-center gap-4 border-b border-sol-line py-5 transition first:border-t hover:bg-sol-paper/50"
            >
            <x-user.avatar :user="$subscription" size="lg" />

            <div class="min-w-0 flex-1">
                <div class="flex items-baseline justify-between gap-4">
                        <span class="truncate font-display text-lg font-bold text-sol-night transition group-hover:text-sol-mars">
                            {{ $name }}
                        </span>

                    <span class="shrink-0 font-body text-[9px] font-bold uppercase tracking-[0.16em] text-sol-muted">
                            {{ $subscription->subscribers_count }} subs
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
                    No signals
                </span>

                <h2 class="font-display text-2xl font-bold text-sol-night">
                    No subscriptions yet
                </h2>

                <p class="mt-2 font-body text-sm text-sol-muted">
                    {{ $userName }} isn't following anyone on SOL4 yet.
                </p>
            </div>
        @endforelse
    </section>
</x-layouts.app>
