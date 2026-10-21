<div class="public-page process-page mx-auto max-w-5xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="process-intro">
        <div class="process-intro-heading">
            <span class="eyebrow">{{ __('process.eyebrow') }}</span>
            <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('process.title') }}</h1>
        </div>
        <p class="process-intro-summary text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('process.subtitle') }}</p>
    </header>

    <div class="prose-sections process-steps mt-12">
        @foreach (['scoping', 'fixed_scope', 'timeline', 'client_inputs', 'payment', 'communication'] as $index => $section)
            <section class="process-step">
                <span class="process-step-index font-mono tabular-nums" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                <div class="process-step-content">
                    <h2 id="process-step-{{ $section }}" class="font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('process.'.$section.'.title') }}</h2>
                    <p class="whitespace-pre-line text-sm leading-7 text-ink-600 dark:text-ink-300">{{ __('process.'.$section.'.text') }}</p>
                </div>
            </section>
        @endforeach
    </div>

    <div class="process-actions mt-10 flex flex-wrap gap-3">
        <a href="{{ localized_route('contact') }}" wire:navigate class="process-action-primary inline-flex rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('common.start_project') }}</a>
        <a href="{{ localized_route('services') }}" wire:navigate class="process-action-secondary inline-flex rounded-lg border border-ink-300 px-5 py-3 font-medium text-ink-700 transition-colors hover:border-blue-400 hover:text-blue-700 dark:border-ink-700 dark:text-ink-200 dark:hover:text-blue-300">{{ __('nav.services') }}</a>
    </div>
</div>
