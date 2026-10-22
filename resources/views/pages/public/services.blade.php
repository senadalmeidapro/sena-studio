<div class="public-page services-page mx-auto">
    <header class="service-hero">
        <div class="service-hero-copy">
            <span class="eyebrow">{{ __('services.eyebrow') }}</span>
            <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('services.niche_title') }}</h1>
            <p class="mt-5 max-w-3xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('services.niche_text') }}</p>
            <div class="service-hero-meta">
                <div class="service-availability" aria-label="{{ __('services.availability') }}">
                    <span class="service-availability-indicator" aria-hidden="true"></span>
                    <div>
                        <span class="service-availability-label">{{ __('services.availability') }}</span>
                        <strong>{{ __('availability.'.$availability) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <figure class="service-constellation" aria-hidden="true">
            @include('pages.public.partials.service-constellation')
            <figcaption><span>01</span><span>{{ __('services.art_caption') }}</span></figcaption>
        </figure>
    </header>

    <section class="service-map" aria-labelledby="service-map-title">
        <div class="service-map-heading">
            <h2 id="service-map-title" class="font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">{{ __('services.scope_title') }}</h2>
            <span class="service-map-rule" aria-hidden="true"></span>
        </div>

        <div class="service-map-grid">
            @foreach (['backend_engineering', 'apis_integrations', 'software_architecture', 'full_stack_applications', 'devops_infrastructure', 'saas_internal_tools'] as $area)
                <article class="service-area service-area--{{ $area }}">
                    <div class="service-area-mark" aria-hidden="true">
                        @include('pages.public.partials.service-diagram', ['area' => $area])
                    </div>
                    <div class="service-area-copy">
                        <h3 class="font-display text-xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-2xl">{{ __('services.area_'.$area.'_title') }}</h3>
                        <p class="mt-3 max-w-[54ch] text-sm leading-7 text-ink-600 dark:text-ink-300">{{ __('services.area_'.$area.'_text') }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="service-engagement mt-20 grid gap-8 rounded-2xl border p-7 sm:p-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-12">
        <div class="service-engagement-heading">
            <span class="eyebrow">{{ __('services.engagement_eyebrow') }}</span>
            <h2 class="mt-4 max-w-[15ch] font-display text-3xl font-bold tracking-tight text-ink-900 dark:text-ink-50">{{ __('services.offer_title') }}</h2>
        </div>
        <div class="service-engagement-copy space-y-4 leading-relaxed text-ink-700 dark:text-ink-200">
            <p>{{ __('services.offer_text') }}</p>
            <p>{{ __('services.offer_duration') }}</p>
            <p>{{ __('services.offer_scoping') }}</p>
            <div class="service-actions">
                <a href="{{ localized_route('contact') }}" wire:navigate class="service-action-primary">{{ __('common.start_project') }}</a>
                <a href="{{ localized_route('process') }}" wire:navigate class="service-action-secondary">{{ __('process.link_label') }}</a>
                <a href="{{ localized_route('data-handling') }}" wire:navigate class="service-action-secondary">{{ __('data_handling.title') }}</a>
                @if (filled($bookingUrl))
                    <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" class="service-action-secondary">{{ __('services.book_call') }}</a>
                @endif
            </div>
        </div>
    </section>
</div>
