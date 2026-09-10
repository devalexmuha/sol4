@props(['user'])

@php
    $initial = \Illuminate\Support\Str::upper(
        \Illuminate\Support\Str::substr($user->name, 0, 1)
    );
@endphp

<span
    {{ $attributes->class('grid size-10 shrink-0 place-items-center overflow-hidden rounded-full border border-sol-mars/30 bg-sol-night font-display text-sm font-bold text-sol-sand') }}
    title="{{ $user->name }}"
    aria-hidden="true"
>
    {{ $initial }}
</span>
