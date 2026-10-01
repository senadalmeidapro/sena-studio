<div class="public-page services-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-4xl border-b border-border pb-12 motion-safe:animate-fade-up ">
        <span class="eyebrow">{{ __('services.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-text  sm:text-6xl">{{ __('services.niche_title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-text-muted ">{{ __('services.niche_text') }}</p>
        <p class="mt-5 inline-flex rounded-full border border-border bg-accent-soft px-3 py-1.5 text-sm font-medium text-accent   ">{{ __('services.availability') }}: {{ __('availability.'.$availability) }}</p>
    </header>

    <section class="mt-14 grid gap-px overflow-hidden rounded-2xl border border-border bg-border   md:grid-cols-3" aria-label="{{ __('services.scope_title') }}">
        @foreach (['api', 'learning', 'product'] as $capability)
            <article class="bg-surface p-7 sm:p-9">
                <span class="font-mono text-xs tabular-nums text-accent ">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <h2 class="mt-3 font-display text-2xl font-semibold tracking-tight text-text ">{{ __('services.capability_'.$capability) }}</h2>
                <p class="mt-3 leading-relaxed text-text-muted ">{{ __('services.capability_'.$capability.'_text') }}</p>
            </article>
        @endforeach
    </section>

    <section class="mt-24 grid gap-10 rounded-2xl border border-border bg-surface-muted p-7   sm:p-10 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <span class="eyebrow">{{ __('services.engagement_eyebrow') }}</span>
            <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-text ">{{ __('services.offer_title') }}</h2>
        </div>
        <div class="space-y-4 leading-relaxed text-text ">
            <p>{{ __('services.offer_text') }}</p>
            <p>{{ __('services.offer_duration') }}</p>
            <p>{{ __('services.offer_scoping') }}</p>
            <div class="flex flex-wrap gap-3 pt-3">
                <a href="{{ localized_route('contact') }}" wire:navigate class="inline-flex rounded-lg bg-accent px-5 py-3 font-medium text-on-accent transition-colors hover:bg-accent-hover   ">{{ __('common.start_project') }}</a>
                <a href="{{ localized_route('process') }}" wire:navigate class="inline-flex rounded-lg border border-border px-5 py-3 font-medium text-accent transition-colors hover:bg-accent-soft   ">{{ __('process.link_label') }}</a>
                <a href="{{ localized_route('data-handling') }}" wire:navigate class="inline-flex rounded-lg border border-border px-5 py-3 font-medium text-accent transition-colors hover:bg-accent-soft   ">{{ __('data_handling.title') }}</a>
                @if (filled($bookingUrl))
                    <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-lg border border-border px-5 py-3 font-medium text-accent transition-colors hover:bg-accent-soft   ">{{ __('services.book_call') }}</a>
                @endif
            </div>
        </div>
    </section>
</div>
