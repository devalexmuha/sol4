<x-layouts.app :title="'#'.$tag->name.' · Sols · SOL4'">
    <x-post.collection-header
        eyebrow="Image transmissions"
        :title="'All sols for #'.$tag->name"
        :count="$imagePosts->count()"
        :backHref="url('/')"
        backLabel="Back to image orbit"
    />

    <div class="flex w-full flex-col gap-6" aria-label="Image posts tagged #{{ $tag->name }}">
        @forelse ($imagePosts as $imagePost)
            <x-image-post.card :post="$imagePost" />
        @empty
            <div class="w-full rounded-sol border border-dashed border-sol-line bg-sol-panel p-10 text-center">
                <span class="mb-3 block font-body text-[10px] font-bold uppercase tracking-[0.22em] text-sol-mars">No transmissions</span>
                <h2 class="font-display text-2xl font-bold text-sol-night">Nothing tagged #{{ $tag->name }}</h2>
                <p class="mt-2 font-body text-sm text-sol-muted">No image signals carry this tag yet.</p>
            </div>
        @endforelse
    </div>
</x-layouts.app>
