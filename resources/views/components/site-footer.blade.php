<footer class="relative z-10 border-t border-ink-300 bg-canvas dark:border-ink-700 dark:bg-canvas">
    @php
        $cvPrimarySlug = \App\Models\Cv::primary()->value('slug');
        $cvUrl = $cvPrimarySlug ? localized_route('cv.show', $cvPrimarySlug) : null;
    @endphp
    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 md:grid-cols-[1.4fr_0.8fr_0.8fr] lg:px-8">
        <div class="space-y-4">
            <a href="{{ localized_route('home') }}" wire:navigate class="group inline-flex items-center gap-3">
                <x-logo class="size-8" />
                <span class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">Sena&nbsp;Studio</span>
            </a>
            <p class="max-w-sm text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                {{ __('footer.tagline') }}
            </p>
            <p class="flex items-center gap-2 text-[0.72rem] uppercase tracking-[0.18em] text-ink-400 dark:text-ink-500">
                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                {{ __('footer.available') }}
            </p>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">{{ __('footer.navigation') }}</h3>
            <ul class="space-y-2.5 text-sm text-ink-500 dark:text-ink-400">
                <li><a href="{{ localized_route('projects.index') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.projects') }}</a></li>
                <li><a href="{{ localized_route('skills.index') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.skills') }}</a></li>
                <li><a href="{{ localized_route('stack.index') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.stack') }}</a></li>
                <li><a href="{{ localized_route('about') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.about') }}</a></li>
                <li><a href="{{ localized_route('posts.index') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.blog') }}</a></li>
                <li>
                    <a href="{{ $cvUrl ?: '#' }}" wire:navigate @class(['ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300' => $cvUrl, 'pointer-events-none opacity-40' => ! $cvUrl])>{{ __('nav.cv') }}</a>
                </li>
                <li><a href="{{ localized_route('contact') }}" wire:navigate class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('nav.contact') }}</a></li>
            </ul>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">{{ __('footer.availability.title') }}</h3>
            <p class="text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                {{ __('footer.availability.text') }}
            </p>
            <x-front.arrow-link :href="localized_route('contact')" wire:navigate class="mt-4">
                {{ __('footer.project_cta') }}
            </x-front.arrow-link>
        </div>
    </div>

    <div class="border-t border-ink-300 dark:border-ink-700">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-[0.7rem] uppercase tracking-[0.14em] text-ink-400 dark:text-ink-500 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} Sena Studio. {{ __('footer.rights') }}</p>
            <p class="flex items-center gap-5">
                <a href="{{ route('filament.admin.pages.dashboard') }}" class="ink-link transition-colors hover:text-blue-600 dark:hover:text-blue-300">{{ __('footer.admin') }}</a>
                <span>{!! __('footer.built', ['laravel' => '<span class="text-blue-600 dark:text-blue-400">Laravel</span>', 'livewire' => '<span class="text-blue-600 dark:text-blue-400">Livewire</span>']) !!}</span>
            </p>
        </div>
    </div>
</footer>