@props([
    'tags',
    'selected' => [],
])

@php
    $selected = $selected instanceof \Illuminate\Support\Collection
        ? $selected->all()
        : (array) $selected;

    $selected = array_map('strval', $selected);
@endphp

<fieldset {{ $attributes }}>
    <div class="flex items-center justify-between gap-4">
        <legend class="font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-night">
            Tags
        </legend>

        <span class="font-body text-[9px] uppercase tracking-[0.16em] text-sol-muted">
            Select multiple
        </span>
    </div>

    <div class="mt-5 flex flex-wrap gap-x-6 gap-y-4">
        @forelse ($tags as $tag)
            <label class="group cursor-pointer">
                <input
                    type="checkbox"
                    name="tags[]"
                    value="{{ $tag->id }}"
                    class="peer sr-only"
                    @checked(in_array((string) $tag->id, $selected, true))
                >

                <span
                    class="block border-b border-sol-line px-1 py-2
                           font-body text-[10px] font-bold uppercase
                           tracking-[0.14em] text-sol-muted transition
                           group-hover:border-sol-orange group-hover:text-sol-mars
                           peer-checked:border-sol-orange
                           peer-checked:text-sol-mars"
                >
                    #{{ $tag->name }}
                </span>
            </label>
        @empty
            <p class="font-body text-sm text-sol-muted">
                No tags are available.
            </p>
        @endforelse
    </div>
</fieldset>
