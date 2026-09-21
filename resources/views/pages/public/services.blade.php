<div class="public-page services-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-3xl border-b border-ink-300 pb-12 motion-safe:animate-fade-up dark:border-ink-700">
        <span class="eyebrow">{{ __('services.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('services.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.subtitle') }}</p>
    </header>

    <section class="mt-14 grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300 dark:border-ink-700 dark:bg-ink-700/70 sm:grid-cols-2">
        @foreach ([['home.services.web', 'home.services.web_text'], ['home.services.saas', 'home.services.saas_text'], ['home.services.apis', 'home.services.apis_text'], ['home.services.perf', 'home.services.perf_text']] as $index => [$title, $text])
            <article class="bg-card p-7 transition-colors hover:bg-blue-50/60 dark:hover:bg-blue-950/20 sm:p-9">
                <span class="font-mono text-xs font-semibold text-blue-600 dark:text-blue-300">0{{ $index + 1 }}</span>
                <h2 class="mt-8 font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __($title) }}</h2>
                <p class="mt-3 max-w-md leading-relaxed text-ink-600 dark:text-ink-300">{{ __($text) }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-24 grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <span class="eyebrow">{{ __('services.engagement_eyebrow') }}</span>
            <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-ink-900 dark:text-ink-50">{{ __('services.engagement_title') }}</h2>
            <p class="mt-4 max-w-md leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.engagement_text') }}</p>
        </div>
        <div class="grid gap-4">
            @foreach (['mvp', 'audit', 'support'] as $index => $item)
                <article class="rounded-xl border border-ink-300 bg-card p-6 shadow-soft dark:border-ink-700">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="font-display text-xl font-semibold text-ink-900 dark:text-ink-50">{{ __('home.engagement.'.$item) }}</h3>
                        <span class="font-mono text-xs text-blue-600 dark:text-blue-300">0{{ $index + 1 }}</span>
                    </div>
                    <p class="mt-3 leading-relaxed text-ink-600 dark:text-ink-300">{{ __('home.engagement.'.$item.'_text') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-24 border-t border-ink-300 pt-12 dark:border-ink-700">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="eyebrow">{{ __('services.method_eyebrow') }}</span>
                <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-ink-900 dark:text-ink-50">{{ __('home.method.title') }}</h2>
            </div>
            <a href="{{ localized_route('contact') }}" wire:navigate class="inline-flex rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('common.start_project') }}</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach (range(1, 4) as $step)
                <article class="border-l-2 border-blue-500 pl-5">
                    <h3 class="font-display font-semibold text-ink-900 dark:text-ink-50">{{ __('home.method.step'.$step) }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ __('home.method.step'.$step.'_text') }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
