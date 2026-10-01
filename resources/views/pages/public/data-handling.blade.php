<div class="public-page data-handling-page mx-auto max-w-5xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-3xl border-b border-ink-300 pb-10 dark:border-ink-700">
        <span class="eyebrow">{{ __('data_handling.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-ink-900 dark:text-ink-50 sm:text-6xl">{{ __('data_handling.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ __('data_handling.subtitle') }}</p>
    </header>

    <div class="mt-12 divide-y divide-ink-200 dark:divide-ink-700">
        @foreach (['client_data', 'retention', 'subprocessors', 'gdpr_contact'] as $section)
            <section class="py-8">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('data_handling.'.$section.'.title') }}</h2>
                <p class="mt-3 max-w-3xl whitespace-pre-line text-sm leading-7 text-ink-600 dark:text-ink-300">{{ __('data_handling.'.$section.'.text') }}</p>
            </section>
        @endforeach
    </div>

    <a href="{{ localized_route('contact') }}" wire:navigate class="mt-8 inline-flex rounded-lg bg-blue-600 px-5 py-3 font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">{{ __('data_handling.contact_link') }}</a>
</div>
