<div class="public-page process-page">
    <header class="max-w-3xl border-b border-ink-300 pb-10 dark:border-ink-700">
        <span class="eyebrow">{{ __('process.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('process.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('process.subtitle') }}</p>
    </header>

    <div class="process-path">
        @foreach (['scoping', 'fixed_scope', 'timeline', 'client_inputs', 'payment', 'communication'] as $index => $section)
            <section class="process-step">
                <span class="process-step-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                <div>
                    <h2>{{ __('process.'.$section.'.title') }}</h2>
                    <p class="whitespace-pre-line">{{ __('process.'.$section.'.text') }}</p>
                </div>
            </section>
        @endforeach
    </div>

    <div class="mt-10 flex flex-wrap gap-3">
        <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button">{{ __('common.start_project') }} <span aria-hidden="true">↗</span></a>
        <a href="{{ localized_route('services') }}" wire:navigate class="studio-button studio-button--quiet">{{ __('nav.services') }}</a>
    </div>
</div>
