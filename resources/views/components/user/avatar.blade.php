@props([
    'user',
    'size' => 'base',
])

@php
    $profile = $user->userProfile;
    $media = $profile?->media->first();
    $name = $profile?->user_name ?? $user->email;

    $initial = \Illuminate\Support\Str::upper(
        \Illuminate\Support\Str::substr($name, 0, 1)
    );

    $dimension = match ($size) {
        'sm' => 'size-9',
        'lg' => 'size-14',
        default => 'size-10',
    };

    $initialText = match ($size) {
        'sm' => 'text-xs',
        'lg' => 'text-lg',
        default => 'text-sm',
    };
@endphp

@if ($media)
    <img
        src="{{ url($media->media_uri) }}"
        alt="{{ $media->media_alt ?: $name }}"
        title="{{ $name }}"
        loading="lazy"
        {{ $attributes->class($dimension.' shrink-0 rounded-full border border-sol-mars/30 object-cover') }}
    >
@else
    <span
        {{ $attributes->class('grid '.$dimension.' shrink-0 place-items-center overflow-hidden rounded-full border border-sol-mars/30 bg-sol-night font-display '.$initialText.' font-bold text-sol-sand') }}
        title="{{ $name }}"
        aria-hidden="true"
    >
        {{ $initial }}
    </span>
@endif
