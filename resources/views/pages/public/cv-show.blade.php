<div class="public-page cv-page mx-auto max-w-5xl px-4 pb-24 pt-10 sm:px-6 lg:px-8">
    <div class="cv-actions mb-6 flex items-center justify-between gap-4">
        <a href="{{ localized_route('home') }}" wire:navigate class="text-sm text-ink-500 transition-colors hover:text-blue-600 dark:text-ink-400 dark:hover:text-blue-300">
            {{ __('common.back_site') }}
        </a>
        <button type="button" data-cv-print class="rounded-lg border border-ink-300 bg-card px-4 py-2.5 text-sm font-semibold text-ink-700 shadow-soft transition-colors hover:border-blue-400 hover:text-blue-700 dark:border-ink-700 dark:text-ink-200 dark:hover:border-blue-500 dark:hover:text-blue-300">
            {{ __('cv.print') }}
        </button>
    </div>

    @include('pages.public.cv-show._engineering')
</div>