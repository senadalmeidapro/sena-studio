<footer class="studio-footer">
    @php
        $cvPrimarySlug = \App\Models\Cv::primary()->value('slug');
        $cvUrl = $cvPrimarySlug ? localized_route('cv.show', $cvPrimarySlug) : null;
        $showBlog = \App\Models\Post::published()->where('locale', app()->getLocale())->count() >= 2;
    @endphp

    <div class="studio-footer-main">
        <div>
            <span class="studio-kicker">{{ __('footer.available') }}</span>
            <h2 class="studio-footer-title">{{ __('home.cta_banner.title') }}</h2>
            <p class="max-w-2xl text-base leading-relaxed text-[#c5d0c3]">{{ __('home.cta_banner.text') }}</p>
        </div>
        <a href="{{ localized_route('contact') }}" wire:navigate class="studio-button">
            {{ __('home.cta_banner.action') }} <span aria-hidden="true">↗</span>
        </a>
    </div>

    <a href="{{ localized_route('home') }}" wire:navigate class="studio-footer-wordmark" aria-label="Sena Studio — {{ __('nav.home') }}">
        Sena Studio<span>.</span>
    </a>

    <nav class="studio-footer-links" aria-label="{{ __('footer.navigation') }}">
        <a href="{{ localized_route('projects.index') }}" wire:navigate>{{ __('nav.projects') }}</a>
        <a href="{{ localized_route('services') }}" wire:navigate>{{ __('nav.services') }}</a>
        <a href="{{ localized_route('process') }}" wire:navigate>{{ __('nav.process') }}</a>
        <a href="{{ localized_route('skills.index') }}" wire:navigate>{{ __('nav.skills') }}</a>
        <a href="{{ localized_route('about') }}" wire:navigate>{{ __('nav.about') }}</a>
        @if ($showBlog)
            <a href="{{ localized_route('posts.index') }}" wire:navigate>{{ __('nav.blog') }}</a>
        @endif
        @if ($cvUrl)
            <a href="{{ $cvUrl }}" wire:navigate>{{ __('nav.cv') }}</a>
        @endif
        <a href="{{ localized_route('contact') }}" wire:navigate>{{ __('nav.contact') }}</a>
    </nav>

    <div class="studio-footer-bottom">
        <span>© {{ date('Y') }} Sena Studio · {{ __('footer.rights') }}</span>
        <span>{{ __('home.stats_location') }}</span>
        <span>{!! __('footer.built', ['laravel' => '<span class="text-[#f07a5c]">Laravel</span>', 'livewire' => '<span class="text-[#f07a5c]">Livewire</span>']) !!}</span>
        <div class="flex flex-wrap gap-4">
            <a href="{{ localized_route('legal.notice') }}" wire:navigate>{{ __('footer.legal_notice') }}</a>
            <a href="{{ localized_route('legal.privacy') }}" wire:navigate>{{ __('footer.privacy') }}</a>
            <a href="{{ localized_route('data-handling') }}" wire:navigate>{{ __('data_handling.title') }}</a>
        </div>
    </div>
</footer>
