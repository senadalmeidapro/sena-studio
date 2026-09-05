<footer class="relative z-10 border-t border-ink-300 bg-white dark:border-ink-700 dark:bg-ink-950">
    @php
        $cvPrimarySlug = \App\Models\Cv::primary()->value('slug');
        $cvUrl = $cvPrimarySlug ? route('cv.show', $cvPrimarySlug) : null;
    @endphp
    <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 md:grid-cols-[1.4fr_0.8fr_0.8fr] lg:px-8">
        <div class="space-y-4">
            <a href="{{ route('home') }}" wire:navigate class="group inline-flex items-center gap-3">
                <x-logo class="size-8" />
                <span class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">Sena&nbsp;Studio</span>
            </a>
            <p class="max-w-sm text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                Studio indépendant — conception de produits web, applications et solutions sur mesure, de l'idée à la mise en production.
            </p>
            <p class="flex items-center gap-2 text-[0.72rem] uppercase tracking-[0.18em] text-ink-400 dark:text-ink-500">
                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                Disponible pour de nouveaux projets
            </p>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">Navigation</h3>
            <ul class="space-y-2.5 text-sm text-ink-500 dark:text-ink-400">
                <li><a href="{{ route('projects.index') }}" wire:navigate class="ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Projets</a></li>
                <li><a href="{{ route('skills.index') }}" wire:navigate class="ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Compétences</a></li>
                <li><a href="{{ route('stack.index') }}" wire:navigate class="ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Stack technique</a></li>
                <li>
                    <a href="{{ $cvUrl ?: '#' }}" wire:navigate @class(['ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300' => $cvUrl, 'pointer-events-none opacity-40' => ! $cvUrl])>CV</a>
                </li>
                <li><a href="{{ route('contact') }}" wire:navigate class="ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Contact</a></li>
            </ul>
        </div>

        <div class="sm:pt-2">
            <h3 class="eyebrow mb-4">Disponibilité</h3>
            <p class="text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                Ouvert aux nouvelles collaborations : projets web, SaaS et backoffices.
            </p>
            <x-front.arrow-link :href="route('contact')" wire:navigate class="mt-4">
                Parlons de votre projet
            </x-front.arrow-link>
        </div>
    </div>

    <div class="border-t border-ink-300 dark:border-ink-700">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-[0.7rem] uppercase tracking-[0.14em] text-ink-400 dark:text-ink-500 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} Sena Studio. Tous droits réservés.</p>
            <p class="flex items-center gap-5">
                <a href="{{ route('login') }}" class="ink-link transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Espace admin</a>
                <span>Conçu avec <span class="text-emerald-600 dark:text-emerald-400">Laravel</span> &amp; <span class="text-emerald-600 dark:text-emerald-400">Livewire</span></span>
            </p>
        </div>
    </div>
</footer>