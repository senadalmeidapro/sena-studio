<div class="public-page services-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-3xl border-b border-ink-300 pb-12 motion-safe:animate-fade-up dark:border-ink-700">
        <span class="eyebrow">{{ __('services.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('services.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.subtitle') }}</p>
    </header>

    <section class="mt-14 grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300 dark:border-ink-700 dark:bg-ink-700/70 sm:grid-cols-2" aria-label="{{ __('services.scope_title') }}">
        @foreach ([['web', 'home.services.web', 'home.services.web_text'], ['operations', 'home.services.saas', 'home.services.saas_text'], ['apis', 'home.services.apis', 'home.services.apis_text'], ['evolution', 'home.services.perf', 'home.services.perf_text']] as [$key, $title, $text])
            <article class="group bg-card p-7 transition-colors hover:bg-blue-50/60 dark:hover:bg-blue-950/20 sm:p-9">
                <span class="font-mono text-xs tabular-nums text-blue-600 dark:text-blue-300">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h2 class="font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __($title) }}</h2>
                <p class="mt-3 max-w-md leading-relaxed text-ink-600 dark:text-ink-300">{{ __($text) }}</p>
                <div class="mt-6 grid gap-5 border-t border-ink-200 pt-5 dark:border-ink-700 sm:grid-cols-2">
                    <div>
                        <h3 class="font-mono text-[0.66rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('services.deliverables') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-700 dark:text-ink-200">{{ __('services.'.$key.'_deliverables') }}</p>
                    </div>
                    <div>
                        <h3 class="font-mono text-[0.66rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('services.best_when') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-ink-700 dark:text-ink-200">{{ __('services.'.$key.'_fit') }}</p>
                    </div>
                </div>
                @if (($this->proofProjects[$key] ?? collect())->isNotEmpty())
                    <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm">
                        <span class="text-ink-500 dark:text-ink-400">{{ __('services.related_work') }}</span>
                        @foreach ($this->proofProjects[$key] as $proof)
                            <a href="{{ localized_route('projects.show', $proof->slug) }}" wire:navigate class="font-medium text-blue-700 underline decoration-blue-300/60 underline-offset-4 transition-colors hover:text-blue-900 dark:text-blue-300 dark:hover:text-blue-100">{{ $proof->name }}</a>
                        @endforeach
                    </div>
                @endif
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
            @foreach (['mvp', 'audit', 'continuous'] as $item)
                <article class="rounded-xl border border-ink-300 bg-card p-6 shadow-soft dark:border-ink-700">
                    <div>
                        <h3 class="font-display text-xl font-semibold text-ink-900 dark:text-ink-50">{{ __('home.engagement.'.$item) }}</h3>
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
