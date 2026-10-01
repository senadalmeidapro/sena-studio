<div class="public-page process-page mx-auto max-w-5xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-3xl border-b border-border pb-10 ">
        <span class="eyebrow">{{ __('process.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-text  sm:text-6xl">{{ __('process.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-text-muted ">{{ __('process.subtitle') }}</p>
    </header>

    <div class="mt-12 divide-y divide-border ">
        @foreach (['scoping', 'fixed_scope', 'timeline', 'client_inputs', 'payment', 'communication'] as $index => $section)
            <section class="grid gap-4 py-8 sm:grid-cols-[5rem_1fr] sm:gap-8">
                <span class="font-mono text-sm tabular-nums text-text-muted">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                <div>
                    <h2 class="font-display text-2xl font-semibold tracking-tight text-text ">{{ __('process.'.$section.'.title') }}</h2>
                    <p class="mt-3 max-w-3xl whitespace-pre-line text-sm leading-7 text-text-muted ">{{ __('process.'.$section.'.text') }}</p>
                </div>
            </section>
        @endforeach
    </div>

    <div class="mt-10 flex flex-wrap gap-3">
        <a href="{{ localized_route('contact') }}" wire:navigate class="inline-flex rounded-lg bg-accent px-5 py-3 font-medium text-on-accent transition-colors hover:bg-accent-hover   ">{{ __('common.start_project') }}</a>
        <a href="{{ localized_route('services') }}" wire:navigate class="inline-flex rounded-lg border border-border px-5 py-3 font-medium text-text transition-colors hover:border-border hover:text-accent   ">{{ __('nav.services') }}</a>
    </div>
</div>
