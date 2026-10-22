@if (filled(config('services.analytics.script')) && filled(config('services.analytics.provider')))
    <aside
        data-privacy-consent
        data-provider="{{ config('services.analytics.provider') }}"
        data-consent-endpoint="{{ route('privacy.consent.store') }}"
        class="privacy-consent-panel fixed inset-x-4 bottom-4 z-[100] mx-auto hidden max-w-3xl rounded-2xl border border-ink-300 bg-canvas p-5 text-ink-900 shadow-2xl dark:border-ink-700 dark:bg-ink-950 dark:text-ink-100 sm:inset-x-6 sm:p-6"
        role="dialog"
        aria-labelledby="privacy-consent-title"
        aria-describedby="privacy-consent-description"
        aria-modal="false"
    >
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-xl">
                <h2 id="privacy-consent-title" class="font-display text-lg font-semibold">{{ __('privacy_consent.title') }}</h2>
                <p id="privacy-consent-description" class="mt-2 text-sm leading-6 text-ink-600 dark:text-ink-300">
                    {{ __('privacy_consent.description', ['provider' => config('services.analytics.provider')]) }}
                    <a href="{{ localized_route('legal.privacy') }}" wire:navigate class="underline underline-offset-4">{{ __('footer.privacy') }}</a>
                </p>
            </div>
            <div class="flex shrink-0 flex-wrap gap-2">
                <button type="button" data-consent-choice="denied" class="privacy-consent-action privacy-consent-action-secondary rounded-lg border border-ink-300 px-4 py-2.5 text-sm font-medium transition-colors hover:bg-ink-100 dark:border-ink-700 dark:hover:bg-ink-900">{{ __('privacy_consent.reject') }}</button>
                <button type="button" data-consent-choice="granted" class="privacy-consent-action privacy-consent-action-primary rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('privacy_consent.accept') }}</button>
            </div>
        </div>
    </aside>
@endif
