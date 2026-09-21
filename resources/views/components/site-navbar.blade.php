@props(['current' => ''])

@php
    $cvPrimary = \App\Models\Cv::primary()->value('slug');
    $cvUrl = $cvPrimary ? localized_route('cv.show', $cvPrimary) : null;

    $links = [
        'projects' => [__('nav.projects'), localized_route('projects.index')],
        'services' => [__('nav.services'), localized_route('services')],
        'skills' => [__('nav.skills'), localized_route('skills.index')],
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
        'fr' => ['label' => 'Francais', 'url' => '/fr'.$localeTail],
        'en' => ['label' => 'English', 'url' => '/en'.$localeTail],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-ink-200/90 bg-canvas/90 backdrop-blur-md dark:border-ink-800 dark:bg-canvas/90">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ localized_route('home') }}" class="group flex items-center gap-2.5" wire:navigate>
            <x-logo class="size-7 transition-transform duration-300 group-hover:scale-105" />
            <span class="font-display text-[1.05rem] font-semibold tracking-[-0.02em] text-ink-900 dark:text-ink-100">Sena Studio</span>
        </a>

        <nav class="hidden items-center gap-6 xl:flex 2xl:gap-8">
            @foreach ($links as $key => [$label, $url])
                <a
                    href="{{ $url }}"
                    wire:navigate
                    @class([
                        'nav-link pb-0.5',
                        'nav-link-active' => $activeKey === $key,
                        'pointer-events-none opacity-40' => ! $cvUrl && $key === 'cv',
                    ])
                >
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ localized_route('contact') }}" wire:navigate class="group hidden items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] text-white shadow-soft transition-all duration-200 hover:-translate-y-px hover:bg-blue-700 xl:inline-flex dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">
                {{ __('nav.discuss') }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:translate-x-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>

            @if ($cvUrl)
                <a href="{{ $cvUrl }}" wire:navigate @class([
                    'hidden rounded-lg px-3.5 py-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] transition-colors xl:inline-flex',
                    'border border-blue-500 bg-blue-50 text-blue-700 dark:border-blue-500 dark:bg-blue-500/15 dark:text-blue-300' => request()->routeIs('cv.show'),
                    'border border-ink-300 text-ink-700 hover:border-blue-400 hover:text-blue-700 dark:border-ink-700 dark:text-ink-200 dark:hover:border-blue-500 dark:hover:text-blue-300' => ! request()->routeIs('cv.show'),
                ])>
                    {{ __('nav.cv') }}
                </a>
            @endif

            {{-- Switcher de langue --}}
            <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative hidden lg:block">
                <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="listbox" aria-label="{{ __('nav.language') }}" class="inline-flex h-8 items-center gap-1.5 rounded-lg border border-ink-300/80 bg-ink-100/60 px-2.5 font-mono text-[0.68rem] font-semibold uppercase tracking-[0.12em] text-ink-600 transition-colors hover:border-blue-400 hover:text-blue-700 dark:border-ink-700/80 dark:bg-ink-800/60 dark:text-ink-300 dark:hover:border-blue-500/60 dark:hover:text-blue-300">
                    {{ strtoupper($locale) }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5 transition-transform" :class="open ? 'rotate-180' : ''" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 9 5.25 5.25L17.25 9" />
                    </svg>
                </button>
                <div x-cloak x-show="open" x-transition role="listbox" class="absolute right-0 top-10 z-50 w-[220px] min-w-[220px] rounded-xl border border-ink-200 bg-card p-1.5 shadow-card dark:border-ink-700 dark:bg-elevated">
                        @foreach ($localeOptions as $code => $option)
                        <a href="{{ $option['url'] }}" wire:navigate @class([
                            'block rounded-lg px-3 py-2 text-sm transition-colors whitespace-nowrap',
                            'bg-blue-50 font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' => $locale === $code,
                            'text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-ink-800/50' => $locale !== $code,
                        ]) role="option" aria-selected="{{ $locale === $code ? 'true' : 'false' }}">
                            {{ strtoupper($code) }} - {{ $option['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Theme switcher : clair / système / sombre --}}
            <div
                x-data="{ active: window.Flux.appearance }"
                x-init="$watch(() => window.Flux.appearance, value => active = value)"
                class="flex items-center gap-0.5 rounded-full border border-ink-300/80 bg-ink-100/60 p-0.5 dark:border-ink-700/80 dark:bg-ink-800/60"
                role="group"
                aria-label="Bascule de thème"
            >
                @foreach ([
                    'light' => [__('nav.theme.light'), 'M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z'],
                    'system' => [__('nav.theme.system'), 'M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3'],
                    'dark' => [__('nav.theme.dark'), 'M3 11.25a9.75 9.75 0 1 1 18.125 4.5A9.75 9.75 0 0 1 3 11.251Z'],
                ] as $theme => [$label, $icon])
                    <button
                        type="button"
                        @click="window.Flux.appearance = @js($theme)"
                        :aria-pressed="active === @js($theme)"
                        :class="active === @js($theme) ? 'bg-white text-ink-900 shadow-sm dark:bg-ink-700 dark:text-ink-50' : 'text-ink-500 hover:bg-white hover:text-ink-800 dark:text-ink-400 dark:hover:bg-ink-700/60 dark:hover:text-ink-100'"
                        class="flex size-7 items-center justify-center rounded-full transition-all duration-200"
                        :aria-label="'{{ $label }}'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </button>
                @endforeach
            </div>

            {{-- Mobile toggle --}}
            <button
                type="button"
                class="inline-flex size-10 shrink-0 items-center justify-center rounded-lg text-ink-600 transition-colors hover:bg-ink-100 xl:hidden dark:text-ink-200 dark:hover:bg-ink-800/60"
                :aria-label="__('nav.menu')"
                data-site-mobile-toggle
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="hidden border-t border-ink-300 bg-canvas xl:hidden dark:border-ink-700" data-site-mobile-menu>
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4">
            @foreach ($links as $key => [$label, $url])
                <a
                    href="{{ $url }}"
                    wire:navigate
                    @class([
                        'rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' => $activeKey === $key,
                        'text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-ink-800/50' => $activeKey !== $key,
                        'pointer-events-none opacity-40' => ($key === 'cv' && ! $cvUrl),
                    ])
                >
                    {{ $label }}
                </a>
            @endforeach
            <div class="mt-2 border-t border-ink-300 pt-3 dark:border-ink-700">
                <a href="{{ localized_route('contact') }}" wire:navigate class="block rounded-lg px-3 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-100 dark:text-blue-300 dark:hover:bg-blue-500/15">
                    {{ __('nav.discuss') }} →
                </a>
                <div x-data="{ open: false }" class="rounded-lg border border-ink-200 dark:border-ink-700">
                    <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="listbox" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-ink-800/50">
                        <span>{{ __('nav.language') }}: {{ strtoupper($locale) }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4 transition-transform" :class="open ? 'rotate-180' : ''" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 9 5.25 5.25L17.25 9" />
                        </svg>
                    </button>
                    <div x-cloak x-show="open" x-transition role="listbox" class="border-t border-ink-200 p-1.5 dark:border-ink-700">
                        @foreach ($localeOptions as $code => $option)
                            <a href="{{ $option['url'] }}" wire:navigate @class([
                                'block rounded-lg px-3 py-2 text-sm transition-colors',
                                'bg-blue-50 font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300' => $locale === $code,
                                'text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-ink-800/50' => $locale !== $code,
                            ]) role="option" aria-selected="{{ $locale === $code ? 'true' : 'false' }}">
                                {{ strtoupper($code) }} - {{ $option['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @if ($cvUrl)
                    <a href="{{ $cvUrl }}" wire:navigate class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-500 hover:bg-ink-100 dark:text-ink-400 dark:hover:bg-ink-800/50">
                        {{ __('nav.cv') }}
                    </a>
                @endif
            </div>
        </nav>
    </div>
</header>
