<div class="public-page cv-page mx-auto max-w-5xl px-4 pb-24 pt-10 sm:px-6 lg:px-8">
    <div class="cv-actions mb-6 flex items-center justify-between gap-4">
        <a href="{{ localized_route('home') }}" wire:navigate class="text-sm text-text-muted transition-colors hover:text-accent  ">
            {{ __('common.back_site') }}
        </a>
        <button type="button" data-cv-print class="rounded-lg border border-border bg-surface px-4 py-2.5 text-sm font-semibold text-text shadow-soft transition-colors hover:border-border hover:text-accent    ">
            {{ __('cv.print') }}
        </button>
    </div>

    @include('pages.public.cv-show._engineering')
</div>