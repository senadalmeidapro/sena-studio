<div class="public-page services-page">
    <header class="max-w-4xl border-b border-ink-300 pb-12 motion-safe:animate-fade-up dark:border-ink-700">
        <span class="eyebrow">{{ __('services.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('services.niche_title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.niche_text') }}</p>
        <p class="service-availability"><span aria-hidden="true"></span>{{ __('services.availability') }}: {{ __('availability.'.$availability) }}</p>
    </header>

    <section class="service-capability-list" aria-label="{{ __('services.scope_title') }}">
        @foreach (['api', 'learning', 'product'] as $capability)
            <article class="service-capability">
                <span class="service-capability-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ __('services.scope_title') }}</span>
                <h2>{{ __('services.capability_'.$capability) }}</h2>
                <p>{{ __('services.capability_'.$capability.'_text') }}</p>
            </article>
        @endforeach
    </section>

    <section class="service-offer">
        <div>
            <span class="eyebrow">{{ __('services.engagement_eyebrow') }}</span>
            <h2>{{ __('services.offer_title') }}</h2>
        </div>
        <div class="space-y-4 leading-relaxed text-ink-700 dark:text-ink-200">
            <p>{{ __('services.offer_text') }}</p>
            <p>{{ __('services.offer_duration') }}</p>
            <p>{{ __('services.offer_scoping') }}</p>
            <div class="flex flex-wrap gap-3 pt-3">
                <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button">{{ __('common.start_project') }} <span aria-hidden="true">↗</span></a>
                <a href="{{ localized_route('process') }}" wire:navigate class="studio-button studio-button--quiet">{{ __('process.link_label') }}</a>
                <a href="{{ localized_route('data-handling') }}" wire:navigate class="studio-button studio-button--quiet">{{ __('data_handling.title') }}</a>
                @if (filled($bookingUrl))
                    <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" class="studio-button studio-button--quiet">{{ __('services.book_call') }} ↗</a>
                @endif
            </div>
        </div>
    </section>
</div>
