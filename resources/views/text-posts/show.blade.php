<x-layouts.app :title="'Echo '.str_pad($textPost->id, 3, '0', STR_PAD_LEFT).' · SOL4'">
    <main class="w-full pb-28 pt-8">
        <div class="mx-auto w-full max-w-300 px-4 sm:px-6 lg:px-8">
            {{-- Back link --}}
            <a
                href="{{ url('/echoes') }}"
                class="group inline-flex items-center gap-3 font-body text-[10px] font-bold uppercase tracking-[0.2em] text-sol-muted transition hover:text-sol-mars"
            >
                <svg
                    class="size-4 transition group-hover:-translate-x-1"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    aria-hidden="true"
                >
                    <path d="m15 18-6-6 6-6"></path>
                </svg>

                Back to echoes
            </a>

            <div class="mt-8 grid items-start gap-12 xl:grid-cols-[minmax(0,1fr)_25rem]">
                {{-- Text post --}}
                <article class="min-w-0">
                    <header class="flex items-center justify-between gap-5 px-1 pb-5">
                        <x-post.author :user="$textPost->user" :time="$textPost->created_at" size="lg" />

                        <div class="flex shrink-0 items-center gap-5">
                            @can('modify', $textPost)
                                <a
                                    href="{{ url('/echoes/'.$textPost->id.'/edit') }}"
                                    class="font-body text-[9px] font-bold uppercase tracking-[0.18em] text-sol-muted transition hover:text-sol-mars"
                                >
                                    Edit
                                </a>
                            @endcan

                            <span class="flex items-center gap-3 font-body text-[10px] font-bold uppercase tracking-[0.18em] text-sol-mars">
                                <span class="h-5 w-px bg-sol-orange"></span>

                                Echo {{ str_pad($textPost->id, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </header>

                    {{-- Content --}}
                    <div class="relative border-l-2 border-sol-orange bg-sol-paper/55 px-6 py-8 sm:px-8 sm:py-10">
                        <p class="whitespace-pre-line font-display text-xl font-bold leading-9 text-sol-night sm:text-2xl sm:leading-10">
                            {{ $textPost->content }}
                        </p>
                    </div>

                    <div class="px-1 pt-5">
                        <x-post.stats
                            :likes="$textPost->likes->count()"
                            :comments="$textPost->comments->count()"
                        />

                        <x-post.tag-chips :tags="$textPost->tags" class="mt-5" />
                    </div>
                </article>

                {{-- Comments panel --}}
                <x-comments.panel
                    :comments="$textPost->comments"
                    :action="url('/echoes/'.$textPost->id.'/comments')"
                />
            </div>
        </div>
    </main>
</x-layouts.app>
