<div class="public-page article-page mx-auto max-w-3xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    @if ($preview ?? false)
        <div class="mb-8 flex items-center gap-3 rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 font-mono text-xs uppercase tracking-[0.12em] text-amber-800 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-amber-200">
            <span class="size-2 rounded-full bg-amber-500"></span>
            Aperçu privé — ce contenu n’est pas publié
        </div>
    @endif

    <a href="{{ localized_route('posts.index') }}" wire:navigate class="group inline-flex items-center gap-1.5 font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 transition-colors hover:text-blue-600 dark:text-ink-400 dark:hover:text-blue-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:-translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        {{ __('common.back_blog') }}
    </a>

    <header class="mt-8 border-b border-ink-300 pb-8 motion-safe:animate-fade-up dark:border-ink-700">
        @if ($post->categories->isNotEmpty())
            <div class="mb-4 flex flex-wrap gap-1.5">
                @foreach ($post->categories as $cat)
                    <span class="rounded-md bg-blue-100/70 px-2.5 py-1 font-mono text-[0.64rem] uppercase tracking-[0.08em] text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">{{ $cat->name }}</span>
                @endforeach
            </div>
        @endif

        <h1 class="font-display text-3xl font-bold tracking-[-0.04em] text-ink-900 dark:text-ink-50 sm:text-4xl">
            {{ $post->title }}
        </h1>

        <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">
            <span>{{ $post->published_at?->translatedFormat('d M Y') }}</span>
            <span class="text-ink-300 dark:text-ink-600">·</span>
            <span>{{ __('blog.reading', ['count' => $post->readingMinutes()]) }}</span>
            <span class="text-ink-300 dark:text-ink-600">·</span>
            <span>{{ __('common.by', ['name' => $post->author?->name ?? 'Sena Studio']) }}</span>
        </div>
    </header>

    @if ($post->excerpt)
        <p class="mt-8 border-l-2 border-blue-500 pl-5 font-display text-xl leading-relaxed text-ink-800 dark:text-ink-100 sm:text-2xl">
            {{ $post->excerpt }}
        </p>
    @endif

    @if ($post->cover_image)
        <div class="mt-10 overflow-hidden rounded-3xl border border-ink-300 bg-ink-100 motion-safe:animate-fade-up [animation-delay:100ms] dark:border-ink-700 dark:bg-ink-900">
            <img src="{{ media_url($post->cover_image, 'f_auto,q_auto,w_1400') }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="aspect-video w-full object-cover" />
        </div>
    @endif

    <div class="prose-blog mt-10 motion-safe:animate-fade-up [animation-delay:180ms]">
        {!! $post->content !!}
    </div>

    @if (! ($preview ?? false) && $this->relatedPosts->isNotEmpty())
        <section class="mt-16 border-t border-ink-300 pt-10 dark:border-ink-700" aria-labelledby="related-reading-title">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">{{ __('blog.related_eyebrow') }}</p>
                    <h2 id="related-reading-title" class="mt-2 font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('blog.related_title') }}</h2>
                </div>
                <a href="{{ localized_route('posts.index') }}" wire:navigate class="text-sm font-medium text-blue-700 underline underline-offset-4 hover:text-blue-900 dark:text-blue-300 dark:hover:text-blue-100">{{ __('common.back_blog') }}</a>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($this->relatedPosts as $related)
                    <a href="{{ localized_route('posts.show', $related->slug) }}" wire:navigate class="group rounded-xl border border-ink-200 bg-card p-5 transition-colors hover:border-blue-400/70 hover:bg-blue-50/40 dark:border-ink-700 dark:hover:bg-blue-950/20">
                        <span class="font-mono text-[0.65rem] uppercase tracking-[0.12em] text-ink-500 dark:text-ink-400">{{ $related->published_at?->translatedFormat('d M Y') }} · {{ __('blog.reading', ['count' => $related->readingMinutes()]) }}</span>
                        <h3 class="mt-2 font-display text-lg font-semibold text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">{{ $related->title }}</h3>
                        @if ($related->excerpt)
                            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ $related->excerpt }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <div class="mt-16 flex flex-wrap items-center justify-between gap-6 rounded-2xl border border-ink-300 bg-blue-50/50 px-8 py-7 shadow-soft dark:border-ink-700 dark:bg-blue-950/20">
        <p class="font-display text-xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
            {{ __('blog.cta_title') }}
        </p>
        <x-front.arrow-link :href="localized_route('contact')" wire:navigate>
            {{ __('blog.cta_action') }}
        </x-front.arrow-link>
    </div>
</div>
