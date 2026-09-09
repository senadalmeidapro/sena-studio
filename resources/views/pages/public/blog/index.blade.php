<div class="mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('blog.index_eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('blog.index_title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('blog.index_subtitle') }}
        </p>
    </header>

    {{-- Catégories --}}
    @if ($this->categories->isNotEmpty())
        <div class="mt-8 flex flex-wrap gap-2">
            <button
                type="button"
                wire:click="filterByCategory(null)"
                class="rounded-lg border px-3 py-1.5 font-mono text-[0.7rem] uppercase tracking-[0.1em] transition-colors"
                @class([
                    'border-blue-500 bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' => blank($category),
                    'border-ink-300 bg-card text-ink-500 hover:text-ink-800 dark:border-ink-700 dark:text-ink-400 dark:hover:text-ink-100' => filled($category),
                ])
            >
                {{ __('common.all') }}
            </button>
            @foreach ($this->categories as $cat)
                <button
                    type="button"
                    wire:click="filterByCategory(@js($cat->slug))"
                    class="rounded-lg border px-3 py-1.5 font-mono text-[0.7rem] uppercase tracking-[0.1em] transition-colors"
                    @class([
                        'border-blue-500 bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' => $category === $cat->slug,
                        'border-ink-300 bg-card text-ink-500 hover:text-ink-800 dark:border-ink-700 dark:text-ink-400 dark:hover:text-ink-100' => $category !== $cat->slug,
                    ])
                >
                    {{ $cat->name }}
                    <span class="opacity-60">{{ $cat->posts_count }}</span>
                </button>
            @endforeach
        </div>
    @endif

    {{-- Articles --}}
    @if ($this->posts->isNotEmpty())
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->posts as $post)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-ink-300 bg-card shadow-soft transition-all duration-300 hover:-translate-y-1 hover:border-blue-400/60 hover:shadow-card dark:border-ink-700 dark:hover:border-blue-500/40">
                    <a href="{{ localized_route('posts.show', $post->slug) }}" wire:navigate class="block">
                        <x-project-media :image="$post->cover_image" :label="$post->title" />
                    </a>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-3 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em] text-ink-500 dark:text-ink-400">
                            <time datetime="{{ $post->published_at?->toIso8601String() }}">
                                {{ $post->published_at?->translatedFormat('d M Y') }}
                            </time>
                            <span class="text-ink-300 dark:text-ink-600">·</span>
                            <span>{{ __('blog.reading', ['count' => $post->readingMinutes()]) }}</span>
                        </div>

                        @if ($post->categories->isNotEmpty())
                            <div class="mb-3 flex flex-wrap gap-1.5">
                                @foreach ($post->categories as $cat)
                                    <span class="rounded bg-blue-100/70 px-2 py-0.5 font-mono text-[0.64rem] uppercase tracking-[0.08em] text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <h2 class="font-display text-xl font-medium tracking-tight text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">
                            <a href="{{ localized_route('posts.show', $post->slug) }}" wire:navigate>{{ $post->title }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                            {{ $post->excerpt }}
                        </p>
                        <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-blue-600 transition-colors group-hover:text-blue-700 dark:text-blue-300 dark:group-hover:text-blue-200">
                            {{ __('common.read_article') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-hover:translate-x-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-14">
            {{ $this->posts->links() }}
        </div>
    @else
        <div class="mt-12 rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            {{ __('blog.empty') }}
        </div>
    @endif
</div>