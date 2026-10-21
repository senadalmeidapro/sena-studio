<footer class="site-footer relative z-10">
    <svg class="footer-art" viewBox="0 0 560 420" fill="none" aria-hidden="true" focusable="false">
        <path d="M34 74h112v92h102v-48h82" />
        <path d="M560 92H418v88H320v68H198v96H82" />
        <path d="M350 0v52h-54v66M474 180v84h-92v72h-72v84" />
        <path class="footer-art-cyan" d="M560 330h-82v-74h-96v-76H252v-78h-88" />
        <circle cx="146" cy="74" r="3" />
        <circle cx="248" cy="166" r="3" />
        <circle cx="330" cy="118" r="3" />
        <circle cx="198" cy="344" r="3" />
        <circle cx="382" cy="252" r="3" />
        <circle class="footer-art-node-cyan" cx="164" cy="102" r="3.5" />
        <circle class="footer-art-node-cyan" cx="382" cy="180" r="3.5" />
        <circle class="footer-art-node-cyan" cx="478" cy="330" r="3.5" />
    </svg>
    @php
        $cvPrimarySlug = \App\Models\Cv::primary()->value('slug');
        $cvUrl = $cvPrimarySlug ? localized_route('cv.show', $cvPrimarySlug) : null;
        $showBlog = \App\Models\Post::published()->where('locale', app()->getLocale())->count() >= 2;
    @endphp

    <div class="footer-main footer-layout mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:px-8">
        <div class="footer-brand">
            <a href="{{ localized_route('home') }}" wire:navigate class="footer-wordmark group inline-flex items-center gap-3">
                <x-logo class="size-8" />
                <span>Sena Studio</span>
            </a>
            <p class="footer-tagline">{{ __('footer.tagline') }}</p>
            <p class="footer-location">
                <span class="footer-location-dot" aria-hidden="true"></span>
                {{ __('footer.available') }}
            </p>
        </div>

        <nav class="footer-navigation" aria-label="{{ __('footer.navigation') }}">
            <h2 class="footer-heading">{{ __('footer.navigation') }}</h2>
            <ul class="footer-link-list">
                <li><a href="{{ localized_route('projects.index') }}" wire:navigate>{{ __('nav.projects') }}</a></li>
                <li><a href="{{ localized_route('services') }}" wire:navigate>{{ __('nav.services') }}</a></li>
                <li><a href="{{ localized_route('process') }}" wire:navigate>{{ __('nav.process') }}</a></li>
                <li><a href="{{ localized_route('skills.index') }}" wire:navigate>{{ __('nav.skills') }}</a></li>
                <li><a href="{{ localized_route('about') }}" wire:navigate>{{ __('nav.about') }}</a></li>
                @if ($showBlog)
                    <li><a href="{{ localized_route('posts.index') }}" wire:navigate>{{ __('nav.blog') }}</a></li>
                @endif
                <li>
                    @if ($cvUrl)
                        <a href="{{ $cvUrl }}" wire:navigate>{{ __('nav.cv') }}</a>
                    @else
                        <span class="footer-link-unavailable">{{ __('nav.cv') }}</span>
                    @endif
                </li>
                <li><a href="{{ localized_route('contact') }}" wire:navigate>{{ __('nav.contact') }}</a></li>
            </ul>
        </nav>

        <section class="footer-availability" aria-labelledby="footer-availability-title">
            <h2 class="footer-availability-title" id="footer-availability-title">{{ __('footer.availability.title') }}</h2>
            <p class="footer-availability-copy">{{ __('footer.availability.text') }}</p>
            <x-front.arrow-link :href="localized_route('contact')" wire:navigate class="footer-project-cta mt-5">
                {{ __('footer.project_cta') }}
            </x-front.arrow-link>
        </section>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 sm:flex-row sm:px-6 lg:px-8">
            <p class="footer-copyright">&copy; {{ date('Y') }} Sena Studio. {{ __('footer.rights') }}</p>
            <div class="footer-meta">
                <span class="footer-built-with">{!! __('footer.built', ['laravel' => '<span>Laravel</span>', 'livewire' => '<span>Livewire</span>']) !!}</span>
                <a href="{{ localized_route('legal.notice') }}" wire:navigate>{{ __('footer.legal_notice') }}</a>
                <a href="{{ localized_route('legal.privacy') }}" wire:navigate>{{ __('footer.privacy') }}</a>
                <a href="{{ localized_route('data-handling') }}" wire:navigate>{{ __('data_handling.title') }}</a>
                @if (filled(config('services.analytics.script')) && filled(config('services.analytics.provider')))
                    <button type="button" data-open-privacy-preferences>{{ __('privacy_consent.manage') }}</button>
                @endif
            </div>
        </div>
    </div>
</footer>
