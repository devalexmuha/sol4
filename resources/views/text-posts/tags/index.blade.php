<x-layouts.app :title="'#'.$tag->name.' · Echoes · SOL4'">
    <x-post.collection-header
        eyebrow="Text transmissions"
        :title="'All echoes for #'.$tag->name"
        :count="$textPosts->count()"
        :backHref="url('/echoes')"
        backLabel="Back to echoes"
    />

    <div class="flex w-full flex-col gap-6" aria-label="Text posts tagged #{{ $tag->name }}">
        @forelse ($textPosts as $textPost)
            <x-text-post.card :post="$textPost" />
        @empty
            <div class="w-full rounded-sol border border-dashed border-sol-line bg-sol-panel p-10 text-center">
                <span class="mb-3 block font-body text-[10px] font-bold uppercase tracking-[0.22em] text-sol-mars">No transmissions</span>
                <h2 class="font-display text-2xl font-bold text-sol-night">Nothing tagged #{{ $tag->name }}</h2>
                <p class="mt-2 font-body text-sm text-sol-muted">No text signals carry this tag yet.</p>
            </div>
        @endforelse
    </div>
</x-layouts.app>
