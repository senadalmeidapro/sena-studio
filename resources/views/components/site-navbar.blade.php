@props(['current' => ''])

@php
    $cvPrimary = \App\Models\Cv::primary()->value('slug');
    $cvUrl = $cvPrimary ? route('cv.show', $cvPrimary) : null;
@endphp

<header class="sticky top-0 z-40 border-b border-ink-300 bg-white/90 backdrop-blur-md dark:border-ink-700 dark:bg-ink-950/90">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-2.5" wire:navigate>
            <x-logo class="size-7 transition-transform duration-300 group-hover:scale-105" />
            <span class="font-display text-lg font-medium tracking-tight text-ink-900 dark:text-ink-100">Sena&nbsp;Studio</span>
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            @foreach ([
                'home' => ['Accueil', route('home')],
                'projects' => ['Projets', route('projects.index')],
                'skills' => ['Compétences', route('skills.index')],
                'stack' => ['Stack', route('stack.index')],
                'cv' => ['CV', $cvUrl ?: '#'],
                'contact' => ['Contact', route('contact')],
            ] as $key => [$label, $url])
                <a
                    href="{{ $url }}"
                    wire:navigate
                    @class([
                        'nav-link pb-0.5',
                        'nav-link-active' => $current === $key,
                        'pointer-events-none opacity-40' => ! $cvUrl && $key === 'cv',
                    ])
                >
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('contact') }}" wire:navigate class="group hidden items-center gap-1.5 rounded-full bg-emerald-600 px-5 py-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] text-white transition-colors hover:bg-emerald-700 sm:inline-flex dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400">
                Discutons
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:translate-x-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>

            {{-- Theme switcher : clair / système / sombre --}}
            <div
                x-data="{ active: window.Flux.appearance }"
                x-init="$watch(() => window.Flux.appearance, value => active = value)"
                class="flex items-center gap-0.5 rounded-full border border-ink-300/80 bg-ink-100/60 p-0.5 dark:border-ink-700/80 dark:bg-ink-800/60"
                role="group"
                aria-label="Bascule de thème"
            >
                @foreach ([
                    'light' => ['Clair', 'M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z'],
                    'system' => ['Système', 'M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3'],
                    'dark' => ['Sombre', 'M3 11.25a9.75 9.75 0 1 1 18.125 4.5A9.75 9.75 0 0 1 3 11.251Z'],
                ] as $theme => [$label, $icon])
                    <button
                        type="button"
                        @click="window.Flux.appearance = @js($theme)"
                        :aria-pressed="active === @js($theme)"
                        :class="active === @js($theme) ? 'bg-white text-ink-900 shadow-sm dark:bg-ink-700 dark:text-ink-50' : 'text-ink-500 hover:bg-white hover:text-ink-800 dark:text-ink-400 dark:hover:bg-ink-700/60 dark:hover:text-ink-100'"
                        class="flex size-7 items-center justify-center rounded-full transition-all duration-200"
                        aria-label="Thème {{ $label }}"
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
                class="inline-flex size-10 items-center justify-center rounded-lg text-ink-600 transition-colors hover:bg-ink-100 md:hidden dark:text-ink-200 dark:hover:bg-ink-800/60"
                aria-label="Menu"
                data-site-mobile-toggle
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="hidden border-t border-ink-300 bg-white md:hidden dark:border-ink-700 dark:bg-ink-950" data-site-mobile-menu>
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4">
            @foreach ([
                'home' => ['Accueil', route('home')],
                'projects' => ['Projets', route('projects.index')],
                'skills' => ['Compétences', route('skills.index')],
                'stack' => ['Stack', route('stack.index')],
                'cv' => ['CV', $cvUrl ?: '#'],
                'contact' => ['Contact', route('contact')],
            ] as $key => [$label, $url])
                <a
                    href="{{ $url }}"
                    wire:navigate
                    @class([
                        'rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300' => $current === $key,
                        'text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-ink-800/50' => $current !== $key,
                        'pointer-events-none opacity-40' => ($key === 'cv' && ! $cvUrl),
                    ])
                >
                    {{ $label }}
                </a>
            @endforeach
            <div class="mt-2 border-t border-ink-300 pt-3 dark:border-ink-700">
                <a href="{{ route('contact') }}" wire:navigate class="block rounded-lg px-3 py-2.5 text-sm font-medium text-emerald-600 hover:bg-emerald-100 dark:text-emerald-300 dark:hover:bg-emerald-500/15">
                    Discutons →
                </a>
                <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-500 hover:bg-ink-100 dark:text-ink-400 dark:hover:bg-ink-800/50">
                    Admin
                </a>
            </div>
        </nav>
    </div>
</header>