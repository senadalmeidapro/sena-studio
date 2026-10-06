@props(['current' => ''])

@php
    $cvPrimary = \App\Models\Cv::primary()->value('slug');
    $cvUrl = $cvPrimary ? localized_route('cv.show', $cvPrimary) : null;

    $links = [
        'services' => [__('nav.services'), localized_route('services')],
        'projects' => [__('nav.projects'), localized_route('projects.index')],
        'skills' => [__('nav.skills'), localized_route('skills.index')],
        'process' => [__('nav.process'), localized_route('process')],
        'about' => [__('nav.about'), localized_route('about')],
        'blog' => [__('nav.blog'), localized_route('posts.index')],
        'contact' => [__('nav.contact'), localized_route('contact')],
    ];

    if (\App\Models\Post::published()->where('locale', app()->getLocale())->count() < 2) {
        unset($links['blog']);
    }

    $activeKey = $current ?: match (true) {
        request()->routeIs('projects.*') => 'projects',
        request()->routeIs('services') => 'services',
        request()->routeIs('process') => 'process',
        request()->routeIs('skills.*', 'stack.*') => 'skills',
        request()->routeIs('about') => 'about',
        request()->routeIs('posts.*') => 'blog',
        request()->routeIs('contact') => 'contact',
        default => null,
    };

    $locale = app()->getLocale();
    $pathSegments = collect(explode('/', trim(request()->path(), '/')))->filter()->values();
    if (in_array($pathSegments->first(), ['fr', 'en'], true)) {
        $pathSegments->shift();
    }
    $localeTail = $pathSegments->isEmpty() ? '' : '/'.$pathSegments->implode('/');
    $localeOptions = [
        'fr' => ['label' => 'Français', 'url' => '/fr'.$localeTail],
        'en' => ['label' => 'English', 'url' => '/en'.$localeTail],
    ];
@endphp

<header class="studio-header">
    <div class="studio-header-inner">
        <a href="{{ localized_route('home') }}" class="studio-brand" wire:navigate aria-label="Sena Studio — {{ __('nav.home') }}">
            <span class="studio-brand-symbol" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M23 11.5C23 7.9 20.3 6 16.5 6 13 6 11 7.6 11 10.2c0 2.8 2.4 4.2 5.8 5.4C20 16.7 22 18.3 22 21c0 2.9-2.6 4.6-6 4.6-3.4 0-6.2-1.6-7-4.6" stroke="currentColor" stroke-width="4.4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <span class="studio-brand-wordmark">Sena <span>Studio</span></span>
        </a>

        <nav class="studio-nav" aria-label="{{ __('nav.main') }}">
            @foreach ($links as $key => [$label, $url])
                <a href="{{ $url }}" wire:navigate @if ($activeKey === $key) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        <div class="studio-header-actions">
            <a href="{{ localized_route('contact') }}" wire:navigate class="studio-header-cta">
                {{ __('nav.discuss') }} <span aria-hidden="true">↗</span>
            </a>

            <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="studio-locale">
                <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="listbox" aria-label="{{ __('nav.language') }}">
                    {{ strtoupper($locale) }} <span aria-hidden="true">⌄</span>
                </button>
                <div x-cloak x-show="open" x-transition role="listbox" class="studio-locale-menu">
                    @foreach ($localeOptions as $code => $option)
                        <a href="{{ $option['url'] }}" wire:navigate role="option" aria-selected="{{ $locale === $code ? 'true' : 'false' }}">
                            {{ strtoupper($code) }} · {{ $option['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div x-data="{ active: window.Flux.appearance }" x-init="$watch(() => window.Flux.appearance, value => active = value)" class="studio-theme" role="group" aria-label="{{ __('nav.theme.label') }}">
                @foreach ([
                    'light' => [__('nav.theme.light'), 'M12 3v2m0 14v2m9-9h-2M5 12H3m15.4-6.4-1.4 1.4M7 17l-1.4 1.4m12.8 0L17 17M7 7 5.6 5.6M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z'],
                    'system' => [__('nav.theme.system'), 'M4 5h16v11H4zM9 20h6m-3-4v4'],
                    'dark' => [__('nav.theme.dark'), 'M20.5 15.5A8.5 8.5 0 0 1 8.5 3.5a8.5 8.5 0 1 0 12 12Z'],
                ] as $theme => [$label, $icon])
                    <button type="button" @click="window.Flux.appearance = @js($theme)" :aria-pressed="active === @js($theme)" :aria-label="@js($label)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" /></svg>
                    </button>
                @endforeach
            </div>

            @if ($cvUrl)
                <a href="{{ $cvUrl }}" wire:navigate class="studio-cv-link">{{ __('nav.cv') }}</a>
            @endif

            <button type="button" class="studio-mobile-toggle" aria-label="{{ __('nav.menu') }}" aria-controls="site-mobile-menu" aria-expanded="false" data-site-mobile-toggle>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" /></svg>
            </button>
        </div>
    </div>

    <div id="site-mobile-menu" class="studio-mobile-menu hidden" data-site-mobile-menu>
        <nav class="studio-mobile-nav" aria-label="{{ __('nav.main') }}">
            @foreach ($links as $key => [$label, $url])
                <a href="{{ $url }}" wire:navigate @if ($activeKey === $key) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>
        <div class="studio-mobile-lower">
            <a href="{{ localized_route('contact') }}" wire:navigate>{{ __('nav.discuss') }} ↗</a>
            @if ($cvUrl)
                <a href="{{ $cvUrl }}" wire:navigate>{{ __('nav.cv') }}</a>
            @endif
            <div class="flex flex-wrap gap-4 pt-2">
                @foreach ($localeOptions as $code => $option)
                    <a href="{{ $option['url'] }}" wire:navigate lang="{{ $code }}" @if ($locale === $code) aria-current="page" @endif>{{ strtoupper($code) }} · {{ $option['label'] }}</a>
                @endforeach
            </div>
            <div x-data="{ active: window.Flux.appearance }" x-init="$watch(() => window.Flux.appearance, value => active = value)" class="studio-theme" role="group" aria-label="{{ __('nav.theme.label') }}">
                @foreach ([
                    'light' => [__('nav.theme.light'), 'M12 3v2m0 14v2m9-9h-2M5 12H3m15.4-6.4-1.4 1.4M7 17l-1.4 1.4m12.8 0L17 17M7 7 5.6 5.6M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z'],
                    'system' => [__('nav.theme.system'), 'M4 5h16v11H4zM9 20h6m-3-4v4'],
                    'dark' => [__('nav.theme.dark'), 'M20.5 15.5A8.5 8.5 0 0 1 8.5 3.5a8.5 8.5 0 1 0 12 12Z'],
                ] as $theme => [$label, $icon])
                    <button type="button" @click="window.Flux.appearance = @js($theme)" :aria-pressed="active === @js($theme)" :aria-label="@js($label)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" /></svg>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</header>
