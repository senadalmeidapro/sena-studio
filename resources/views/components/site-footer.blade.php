<footer class="relative z-10 border-t border-ink-200/80 bg-white dark:border-ink-800/60 dark:bg-ink-950">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
        <div class="space-y-3">
            <div class="flex items-center gap-2.5">
                <span class="flex size-7 items-center justify-center rounded-md bg-emerald-500 text-sm font-bold text-white dark:bg-emerald-300 dark:text-emerald-950">
                    S
                </span>
                <span class="font-semibold tracking-tight text-ink-900 dark:text-ink-100">Sena Studio</span>
            </div>
            <p class="max-w-xs text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                Studio freelance &amp; portfolio personnel. Conception de produits web, applications et solutions sur mesure.
            </p>
        </div>

        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-ink-700 dark:text-ink-300">Navigation</h3>
            <ul class="space-y-2 text-sm text-ink-500 dark:text-ink-400">
                <li><a href="{{ route('projects.index') }}" wire:navigate class="transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Projets</a></li>
                <li><a href="{{ route('skills.index') }}" wire:navigate class="transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Compétences</a></li>
                <li><a href="{{ route('stack.index') }}" wire:navigate class="transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Stack technique</a></li>
                <li><a href="{{ route('contact') }}" wire:navigate class="transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-ink-700 dark:text-ink-300">Disponibilité</h3>
            <p class="text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                Ouvert aux nouvelles collaborations.
                <a href="{{ route('contact') }}" wire:navigate class="font-medium text-emerald-600 hover:underline dark:text-emerald-300">Parlons de votre projet →</a>
            </p>
        </div>
    </div>

    <div class="border-t border-ink-200/80 dark:border-ink-800/60">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-4 py-5 text-xs text-ink-500 dark:text-ink-500 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} Sena Studio. Tous droits réservés.</p>
            <p class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="transition-colors hover:text-emerald-600 dark:hover:text-emerald-300">Espace admin</a>
                <span>Conçu avec <span class="text-emerald-600 dark:text-emerald-400">Laravel</span> &amp; <span class="text-emerald-600 dark:text-emerald-400">Livewire</span></span>
            </p>
        </div>
    </div>
</footer>