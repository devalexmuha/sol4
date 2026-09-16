@props([
    'tags',
    'limit' => null,
])

@php
    $items = $limit ? $tags->take($limit) : $tags;
@endphp

@if ($tags->isNotEmpty())
    <div {{ $attributes->class('flex flex-wrap gap-2') }}>
        @foreach ($items as $tag)
            <span class="bg-sol-paper px-2.5 py-1.5 font-body text-[9px] font-bold uppercase tracking-[0.14em] text-sol-mars">
                #{{ $tag->name }}
            </span>
        @endforeach
    </div>
@endif
