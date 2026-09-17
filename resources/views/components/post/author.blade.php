@props([
    'user',
    'time' => null,
    'size' => 'base',
])

@php
    $name = $user->userProfile?->user_name ?? $user->email;
    $nameText = $size === 'lg' ? 'text-lg' : 'text-base';
@endphp

<a
    href="{{ url('/profiles/' . $name) }}"
    {{ $attributes->class('group flex min-w-0 items-center gap-3') }}
>
    <x-user.avatar :user="$user" :size="$size" />

    <span class="min-w-0">
        <span class="block truncate font-display {{ $nameText }} font-bold text-sol-night transition group-hover:text-sol-mars">
            {{ $name }}
        </span>

        @if ($time)
            <span class="block font-body text-[9px] font-semibold uppercase tracking-[0.16em] text-sol-muted">
                {{ $time->diffForHumans() }}
            </span>
        @endif
    </span>
</a>
