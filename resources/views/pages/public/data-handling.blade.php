<div class="public-page data-handling-page mx-auto max-w-5xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">
    <header class="max-w-3xl border-b border-border pb-10 ">
        <span class="eyebrow">{{ __('data_handling.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-bold tracking-[-0.05em] text-text  sm:text-6xl">{{ __('data_handling.title') }}</h1>
        <p class="mt-5 text-pretty text-lg leading-relaxed text-text-muted ">{{ __('data_handling.subtitle') }}</p>
    </header>

    <div class="mt-12 divide-y divide-border ">
        @foreach (['client_data', 'retention', 'subprocessors', 'gdpr_contact'] as $section)
            <section class="py-8">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-text ">{{ __('data_handling.'.$section.'.title') }}</h2>
                <p class="mt-3 max-w-3xl whitespace-pre-line text-sm leading-7 text-text-muted ">{{ __('data_handling.'.$section.'.text') }}</p>
            </section>
        @endforeach
    </div>

    <a href="{{ localized_route('contact') }}" wire:navigate class="mt-8 inline-flex rounded-lg bg-accent px-5 py-3 font-medium text-on-accent transition-colors hover:bg-accent-hover   ">{{ __('data_handling.contact_link') }}</a>
</div>
