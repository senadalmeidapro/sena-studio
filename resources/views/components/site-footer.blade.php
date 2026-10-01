<footer class="relative z-10 border-t border-border bg-bg  ">
    @php
        $cvPrimarySlug = \App\Models\Cv::primary()->value('slug');
        $cvUrl = $cvPrimarySlug ? localized_route('cv.show', $cvPrimarySlug) : null;
        $showBlog = \App\Models\Post::published()->where('locale', app()->getLocale())->count() >= 2;
    @endphp
    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 md:grid-cols-[1.4fr_0.8fr_0.8fr] lg:px-8">
        <div class="space-y-4">
            <a href="{{ localized_route('home') }}" wire:navigate class="group inline-flex items-center gap-3">
                <x-logo class="size-8" />
                <span class="font-display text-2xl font-medium tracking-tight text-text ">Sena Studio</span>
            </a>
            <p class="max-w-sm text-sm leading-relaxed text-text-muted ">
                {{ __('footer.tagline') }}
            </p>
            <p class="flex items-center gap-2 text-[0.72rem] uppercase tracking-[0.18em] text-text-muted">
                <span class="size-1.5 rounded-full bg-accent"></span>
                {{ __('footer.available') }}
            </p>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">{{ __('footer.navigation') }}</h3>
            <ul class="space-y-2.5 text-sm text-text-muted ">
                <li><a href="{{ localized_route('projects.index') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.projects') }}</a></li>
                <li><a href="{{ localized_route('services') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.services') }}</a></li>
                <li><a href="{{ localized_route('process') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.process') }}</a></li>
                <li><a href="{{ localized_route('skills.index') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.skills') }}</a></li>
                <li><a href="{{ localized_route('about') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.about') }}</a></li>
                @if ($showBlog)
                    <li><a href="{{ localized_route('posts.index') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.blog') }}</a></li>
                @endif
                <li>
                    <a href="{{ $cvUrl ?: '#' }}" wire:navigate @class(['ink-link transition-colors hover:text-accent ' => $cvUrl, 'pointer-events-none opacity-40' => ! $cvUrl])>{{ __('nav.cv') }}</a>
                </li>
                <li><a href="{{ localized_route('contact') }}" wire:navigate class="ink-link transition-colors hover:text-accent ">{{ __('nav.contact') }}</a></li>
            </ul>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">{{ __('footer.availability.title') }}</h3>
            <p class="text-sm leading-relaxed text-text-muted ">
                {{ __('footer.availability.text') }}
            </p>
            <x-front.arrow-link :href="localized_route('contact')" wire:navigate class="mt-4">
                {{ __('footer.project_cta') }}
            </x-front.arrow-link>
        </div>
    </div>

    <div class="border-t border-border ">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-[0.7rem] uppercase tracking-[0.14em] text-text-muted sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} Sena Studio. {{ __('footer.rights') }}</p>
            <p class="flex flex-wrap items-center gap-5">
                <span>{!! __('footer.built', ['laravel' => '<span class="text-accent ">Laravel</span>', 'livewire' => '<span class="text-accent ">Livewire</span>']) !!}</span>
                <a href="{{ localized_route('legal.notice') }}" wire:navigate class="transition-colors hover:text-accent ">{{ __('footer.legal_notice') }}</a>
                <a href="{{ localized_route('legal.privacy') }}" wire:navigate class="transition-colors hover:text-accent ">{{ __('footer.privacy') }}</a>
                <a href="{{ localized_route('data-handling') }}" wire:navigate class="transition-colors hover:text-accent ">{{ __('data_handling.title') }}</a>
            </p>
        </div>
    </div>
</footer>
