<div class="public-page cv-page mx-auto">
    <nav class="cv-actions mb-6 flex items-center justify-between gap-4" aria-label="CV actions">
        <a href="{{ localized_route('home') }}" wire:navigate class="text-sm text-ink-500 transition-colors hover:text-blue-600 dark:text-ink-400 dark:hover:text-blue-300">
            {{ __('common.back_site') }}
        </a>
        <button type="button" data-cv-print class="rounded-lg border border-ink-300 bg-card px-4 py-2.5 text-sm font-semibold text-ink-700 transition-colors hover:border-blue-400 hover:text-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 dark:border-ink-700 dark:text-ink-200 dark:hover:border-blue-500 dark:hover:text-blue-300">
            {{ __('cv.print') }}
        </button>
    </nav>

    @include('pages.public.cv-show._engineering')
</div>
