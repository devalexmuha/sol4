@if ($errors->any())
    <div
        {{ $attributes->class(
            'mb-6 rounded-sol border border-dashed border-sol-mars bg-sol-paper px-4 py-3'
        ) }}
        role="alert"
    >
        <span class="block font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
            {{ $errors->first() }}
        </span>
    </div>
@endif
