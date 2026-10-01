@props(['current' => ''])

@php
    $cvPrimary = \App\Models\Cv::primary()->value('slug');
    $cvUrl = $cvPrimary ? localized_route('cv.show', $cvPrimary) : null;

    $links = [
        'projects' => [__('nav.projects'), localized_route('projects.index')],
        'services' => [__('nav.services'), localized_route('services')],
        'process' => [__('nav.process'), localized_route('process')],
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

<header class="sticky top-0 z-40 border-b border-border bg-bg/90 backdrop-blur-md  ">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ localized_route('home') }}" class="group flex items-center gap-2.5" wire:navigate>
            <x-logo class="size-7 transition-transform duration-300 group-hover:scale-105" />
            <span class="font-display text-[1.05rem] font-semibold tracking-[-0.02em] text-text ">Sena Studio</span>
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
            <a href="{{ localized_route('contact') }}" wire:navigate class="group hidden items-center gap-1.5 rounded-lg bg-accent px-4 py-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] text-on-accent shadow-soft transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover xl:inline-flex   ">
                {{ __('nav.discuss') }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:translate-x-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>

            @if ($cvUrl)
                <a href="{{ $cvUrl }}" wire:navigate @class([
                    'hidden rounded-lg px-3.5 py-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] transition-colors xl:inline-flex',
                    'border border-border bg-accent-soft text-accent   ' => request()->routeIs('cv.show'),
                    'border border-border text-text hover:border-border hover:text-accent    ' => ! request()->routeIs('cv.show'),
                ])>
                    {{ __('nav.cv') }}
                </a>
            @endif

            {{-- Switcher de langue --}}
            <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative hidden lg:block">
                <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="listbox" aria-label="{{ __('nav.language') }}" class="inline-flex h-8 items-center gap-1.5 rounded-lg border border-border bg-surface-muted px-2.5 font-mono text-[0.68rem] font-semibold uppercase tracking-[0.12em] text-text-muted transition-colors hover:border-border hover:text-accent     ">
                    {{ strtoupper($locale) }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-3.5 transition-transform" :class="open ? 'rotate-180' : ''" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 9 5.25 5.25L17.25 9" />
                    </svg>
                </button>
                <div x-cloak x-show="open" x-transition role="listbox" class="absolute right-0 top-10 z-50 w-[220px] min-w-[220px] rounded-xl border border-border bg-surface p-1.5 shadow-card  ">
                        @foreach ($localeOptions as $code => $option)
                        <a href="{{ $option['url'] }}" wire:navigate @class([
                            'block rounded-lg px-3 py-2 text-sm transition-colors whitespace-nowrap',
                            'bg-accent-soft font-semibold text-accent  ' => $locale === $code,
                            'text-text-muted hover:bg-surface-muted  ' => $locale !== $code,
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
                class="flex items-center gap-0.5 rounded-full border border-border bg-surface-muted p-0.5  "
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
                        :class="active === @js($theme) ? 'bg-surface text-text shadow-sm  ' : 'text-text-muted hover:bg-surface hover:text-text   '"
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
                class="inline-flex size-10 shrink-0 items-center justify-center rounded-lg text-text-muted transition-colors hover:bg-surface-muted xl:hidden  "
                :aria-label="__('nav.menu')"
                aria-controls="site-mobile-menu"
                aria-expanded="false"
                data-site-mobile-toggle
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="site-mobile-menu" class="hidden border-t border-border bg-bg xl:hidden " data-site-mobile-menu>
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4">
            @foreach ($links as $key => [$label, $url])
                <a
                    href="{{ $url }}"
                    wire:navigate
                    @class([
                        'rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-accent-soft text-accent  ' => $activeKey === $key,
                        'text-text-muted hover:bg-surface-muted  ' => $activeKey !== $key,
                        'pointer-events-none opacity-40' => ($key === 'cv' && ! $cvUrl),
                    ])
                >
                    {{ $label }}
                </a>
            @endforeach
            <div class="mt-2 border-t border-border pt-3 ">
                <a href="{{ localized_route('contact') }}" wire:navigate class="block rounded-lg px-3 py-2.5 text-sm font-medium text-accent hover:bg-accent-soft  ">
                    {{ __('nav.discuss') }} →
                </a>
                <div x-data="{ open: false }" class="rounded-lg border border-border ">
                    <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="listbox" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-text-muted hover:bg-surface-muted  ">
                        <span>{{ __('nav.language') }}: {{ strtoupper($locale) }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4 transition-transform" :class="open ? 'rotate-180' : ''" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 9 5.25 5.25L17.25 9" />
                        </svg>
                    </button>
                    <div x-cloak x-show="open" x-transition role="listbox" class="border-t border-border p-1.5 ">
                        @foreach ($localeOptions as $code => $option)
                            <a href="{{ $option['url'] }}" wire:navigate @class([
                                'block rounded-lg px-3 py-2 text-sm transition-colors',
                                'bg-accent-soft font-semibold text-accent  ' => $locale === $code,
                                'text-text-muted hover:bg-surface-muted  ' => $locale !== $code,
                            ]) role="option" aria-selected="{{ $locale === $code ? 'true' : 'false' }}">
                                {{ strtoupper($code) }} - {{ $option['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @if ($cvUrl)
                    <a href="{{ $cvUrl }}" wire:navigate class="block rounded-lg px-3 py-2.5 text-sm font-medium text-text-muted hover:bg-surface-muted  ">
                        {{ __('nav.cv') }}
                    </a>
                @endif
            </div>
        </nav>
    </div>
</header>
