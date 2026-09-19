@props([
    'tags',
    'type',            // 'sol' (image posts) or 'echoes' (text posts)
    'limit' => null,
])

@php
    $items = $limit ? $tags->take($limit) : $tags;
    // Tag route-model binding uses the tag name (Tag::getRouteKeyName).
    $base = $type === 'echoes' ? '/echoes/tag/' : '/sol/tag/';
@endphp

@if ($tags->isNotEmpty())
    <div {{ $attributes->class('flex flex-wrap gap-2') }}>
        @foreach ($items as $tag)
            <a
                href="{{ url($base . rawurlencode($tag->name)) }}"
                class="relative z-20 rounded-sm border border-sol-line bg-sol-paper px-2.5 py-1.5 font-body text-[9px] font-bold uppercase tracking-[0.14em] text-sol-mars transition hover:border-sol-orange hover:bg-sol-sand/60"
            >
                #{{ $tag->name }}
            </a>
        @endforeach
    </div>
@endif
