<div class="mx-auto max-w-3xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

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

        <h1 class="font-display text-3xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">
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

    @if ($post->cover_image)
        <div class="mt-10 overflow-hidden rounded-3xl border border-ink-300 bg-ink-100 motion-safe:animate-fade-up [animation-delay:100ms] dark:border-ink-700 dark:bg-ink-900">
            <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy" class="aspect-video w-full object-cover" />
        </div>
    @endif

    <div class="prose-blog mt-10 motion-safe:animate-fade-up [animation-delay:180ms]">
        {!! $post->content !!}
    </div>

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