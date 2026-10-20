<div class="public-page legal-page mx-auto max-w-4xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="border-b border-ink-300 pb-10 dark:border-ink-700">
        <span class="eyebrow">{{ __('legal.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">{{ __('legal.privacy_title') }}</h1>
        <p class="mt-4 text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('legal.privacy_description') }}</p>
    </header>
    <div class="prose-legal mt-10">
        <h2>{{ __('legal.data_title') }}</h2>
        <p>{{ __('legal.data_text') }}</p>
        <h2>{{ __('legal.purpose_title') }}</h2>
        <p>{{ __('legal.purpose_text') }}</p>
        <h2>{{ __('legal.storage_title') }}</h2>
        <p>{{ __('legal.storage_text', ['years' => config('privacy.contact_message_retention_years', 3)]) }}</p>
        <h2>{{ __('legal.rights_title') }}</h2>
        <p>{{ __('legal.rights_text') }}</p>
        <h2>{{ __('legal.privacy_confirmation_title') }}</h2>
        <p>{{ __('legal.privacy_confirmation_text') }}</p>
        @if (filled(config('services.analytics.script')) && filled(config('services.analytics.provider')))
            <h2>{{ __('privacy_consent.policy_title') }}</h2>
            <p>{{ __('privacy_consent.policy_text', ['provider' => config('services.analytics.provider')]) }}</p>
            <button type="button" data-open-privacy-preferences class="mt-3 rounded-lg border border-ink-300 px-4 py-2 text-sm font-medium text-ink-700 transition-colors hover:bg-ink-100 dark:border-ink-700 dark:text-ink-200 dark:hover:bg-ink-900">{{ __('privacy_consent.manage') }}</button>
        @endif
    </div>
</div>
