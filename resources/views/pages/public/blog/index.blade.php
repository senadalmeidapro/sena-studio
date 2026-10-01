<div class="public-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-border pb-10 motion-safe:animate-fade-up ">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('blog.index_eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-text  sm:text-5xl">
            {{ __('blog.index_title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-text-muted ">
            {{ __('blog.index_subtitle') }}
        </p>
    </header>

    <section class="mt-10 grid gap-6 rounded-xl border border-border bg-surface p-6  sm:grid-cols-[1.5fr_1fr] sm:items-end sm:p-8">
        <div>
            <p class="eyebrow">{{ __('blog.signal_title') }}</p>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-text-muted ">{{ __('blog.signal_text') }}</p>
        </div>
        <dl class="grid grid-cols-2 gap-4 sm:justify-self-end">
            <div class="border-l border-border pl-4 ">
                <dd class="font-display text-2xl font-semibold tracking-tight text-text ">{{ $this->posts->total() }}</dd>
                <dt class="mt-2 text-xs font-medium text-text ">{{ __('blog.signal_articles') }}</dt>
            </div>
            <div class="border-l border-border pl-4 ">
                <dd class="font-display text-2xl font-semibold tracking-tight text-text ">{{ $this->categories->count() }}</dd>
                <dt class="mt-2 text-xs font-medium text-text ">{{ __('blog.signal_categories') }}</dt>
            </div>
        </dl>
    </section>

    {{-- Catégories --}}
    @if ($this->categories->isNotEmpty())
        <div class="mt-8 flex flex-wrap gap-2">
            <button
                type="button"
                wire:click="filterByCategory(null)"
                class="rounded-lg border px-3 py-1.5 font-mono text-[0.7rem] uppercase tracking-[0.1em] transition-colors"
                @class([
                    'border-border bg-accent-soft text-accent  ' => blank($category),
                    'border-border bg-surface text-text-muted hover:text-text   ' => filled($category),
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
                        'border-border bg-accent-soft text-accent  ' => $category === $cat->slug,
                        'border-border bg-surface text-text-muted hover:text-text   ' => $category !== $cat->slug,
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
                <article class="group flex flex-col overflow-hidden rounded-xl border border-border bg-surface transition-all duration-300 hover:-translate-y-1 hover:border-border hover:shadow-card  ">
                    <a href="{{ localized_route('posts.show', $post->slug) }}" wire:navigate class="block">
                        <x-project-media :image="$post->cover_image" :label="$post->title" />
                    </a>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-3 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em] text-text-muted ">
                            <time datetime="{{ $post->published_at?->toIso8601String() }}">
                                {{ $post->published_at?->translatedFormat('d M Y') }}
                            </time>
                            <span class="text-text-muted ">·</span>
                            <span>{{ __('blog.reading', ['count' => $post->readingMinutes()]) }}</span>
                        </div>

                        @if ($post->categories->isNotEmpty())
                            <div class="mb-3 flex flex-wrap gap-1.5">
                                @foreach ($post->categories as $cat)
                                    <span class="rounded bg-accent-soft px-2 py-0.5 font-mono text-[0.64rem] uppercase tracking-[0.08em] text-accent  ">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <h2 class="font-display text-xl font-medium tracking-tight text-text transition-colors group-hover:text-accent  ">
                            <a href="{{ localized_route('posts.show', $post->slug) }}" wire:navigate>{{ $post->title }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-text-muted ">
                            {{ $post->excerpt }}
                        </p>
                        <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-accent transition-colors group-hover:text-accent  ">
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
        <div class="mt-12 rounded-2xl border border-dashed border-border p-12 text-center text-text-muted  ">
            {{ __('blog.empty') }}
        </div>
    @endif
</div>
