<div class="public-page services-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-4xl border-b border-ink-300 pb-12 motion-safe:animate-fade-up dark:border-ink-700">
        <span class="eyebrow">{{ __('services.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('services.niche_title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.niche_text') }}</p>
        <p class="mt-5 inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-800 dark:border-blue-800 dark:bg-blue-950/30 dark:text-blue-200">{{ __('services.availability') }}: {{ __('availability.'.$availability) }}</p>
    </header>

    <section class="mt-14 grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300 dark:border-ink-700 dark:bg-ink-700/70 md:grid-cols-3" aria-label="{{ __('services.scope_title') }}">
        @foreach (['api', 'learning', 'product'] as $capability)
            <article class="bg-card p-7 sm:p-9">
                <span class="font-mono text-xs tabular-nums text-blue-600 dark:text-blue-300">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h2 class="mt-3 font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('services.capability_'.$capability) }}</h2>
                <p class="mt-3 leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.capability_'.$capability.'_text') }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-24 grid gap-10 rounded-2xl border border-blue-200 bg-blue-50/70 p-7 dark:border-blue-900 dark:bg-blue-950/20 sm:p-10 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <span class="eyebrow">{{ __('services.engagement_eyebrow') }}</span>
            <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-ink-900 dark:text-ink-50">{{ __('services.offer_title') }}</h2>
        </div>
        <div class="space-y-4 leading-relaxed text-ink-700 dark:text-ink-200">
            <p>{{ __('services.offer_text') }}</p>
            <p>{{ __('services.offer_duration') }}</p>
            <p>{{ __('services.offer_scoping') }}</p>
            <div class="flex flex-wrap gap-3 pt-3">
                <a href="{{ localized_route('contact') }}" wire:navigate class="inline-flex rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('common.start_project') }}</a>
                @if (filled($bookingUrl))
                    <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-lg border border-blue-300 px-5 py-3 font-medium text-blue-800 transition-colors hover:bg-blue-100 dark:border-blue-700 dark:text-blue-200 dark:hover:bg-blue-950/60">{{ __('services.book_call') }}</a>
                @endif
            </div>
        </div>
    </section>
</div>
