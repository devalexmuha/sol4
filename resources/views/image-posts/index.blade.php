<x-layouts.app title="Image orbit · SOL4">
    <div class="flex w-full flex-col gap-6" aria-label="Image posts">
        @forelse ($imagePosts as $imagePost)
            <x-image-post.card :post="$imagePost"/>
        @empty
            <div class="w-full rounded-sol border border-dashed border-sol-line bg-sol-panel p-10 text-center">
                <span class="mb-3 block font-body text-[10px] font-bold uppercase tracking-[0.22em] text-sol-mars">No transmissions</span>
                <h2 class="font-display text-2xl font-bold text-sol-night">The orbit is quiet</h2>
                <p class="mt-2 font-body text-sm text-sol-muted">The first image signal has not reached Mars yet.</p>
            </div>
        @endforelse
    </div>
</x-layouts.app>
