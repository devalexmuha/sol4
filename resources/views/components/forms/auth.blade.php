@props([
    'form' => 'login'
])

<div class="flex min-h-[70vh] w-full items-center justify-center">
    <section
        class="relative w-full max-w-md overflow-hidden rounded-sol bg-sol-panel"
        aria-labelledby="login-heading"
    >
        {{-- Corner tag motif --}}
        <span class="absolute right-4 top-4 border-l-2 border-sol-orange pl-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
                Sol 04
            </span>

        {{-- Header --}}
        <header class="px-6 py-8 sm:px-8">
            @if($form === 'login')
            <h1 id="login-heading" class="font-display text-3xl font-bold text-sol-night">
                Log in to SOL4
            </h1>
            @else
            <h1 id="login-heading" class="font-display text-3xl font-bold text-sol-night">
                Join SOL4
            </h1>
            @endif
        </header>

        {{-- Form --}}
        <form method="POST" action="@if($form === 'login'){{ url('/login') }}@else {{ url('/register') }} @endif" class="px-6 py-8 sm:px-8" novalidate>
            @csrf

            {{-- Validation summary --}}
            <x-forms.error/>

            {{-- Email --}}
            <div class="mb-6">
                <label
                    for="email"
                    class="mb-2 block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                >
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="you@orbit.mars"
                    class="h-12 w-full border bg-sol-paper px-4 font-body text-sm text-sol-night placeholder:text-sol-muted/60 transition focus:outline-none @error('email') border-sol-mars @else border-sol-line focus:border-sol-orange @enderror"
                >
            </div>

            {{-- Password --}}


            <div class="mb-8">
                <label
                    for="password"
                    class="mb-2 block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                >
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="h-12 w-full border bg-sol-paper px-4 font-body text-sm text-sol-night placeholder:text-sol-muted/60 transition focus:outline-none @error('password') border-sol-mars @else border-sol-line focus:border-sol-orange @enderror"
                >
            </div>
            @if($form === 'register')
            <div class="mb-8">
                <label
                    for="password_confirmation"
                    class="mb-2 block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-muted"
                >
                    Confirm Your Password
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="h-12 w-full border bg-sol-paper px-4 font-body text-sm text-sol-night placeholder:text-sol-muted/60 transition focus:outline-none @error('password') border-sol-mars @else border-sol-line focus:border-sol-orange @enderror"
                >
            </div>
            @endif
            {{-- Submit --}}
            <button
                type="submit"
                class="flex h-12 w-full items-center justify-center border border-sol-mars bg-sol-mars font-body text-[11px] font-bold uppercase tracking-[0.18em] text-sol-panel transition hover:border-sol-orange hover:bg-sol-orange"
            >
                Enter orbit
            </button>
        </form>

        {{-- Footer --}}
        <footer class="px-6 py-5 text-center sm:px-8">
                <span class="font-body text-sm text-sol-muted">
                    No signal yet?
                    <a
                        href="{{ url('/register') }}"
                        class="font-bold text-sol-mars underline decoration-sol-orange decoration-2 underline-offset-4 transition hover:text-sol-orange"
                    >
                        Register
                    </a>
                </span>
        </footer>
    </section>
</div>
