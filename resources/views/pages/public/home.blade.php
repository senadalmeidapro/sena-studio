<div class="space-y-24 pb-24 sm:space-y-28">

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid [mask-image:radial-gradient(ellipse_at_top,black_35%,transparent_78%)]" aria-hidden="true"></div>
        <div class="pointer-events-none absolute left-[6%] top-24 size-40 animate-drift rounded-full bg-sage-200/70 blur-3xl dark:bg-sage-600/15" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 pt-16 pb-4 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:gap-16 lg:px-8 lg:pt-24">
            {{-- Colonne texte --}}
            <div class="motion-safe:animate-fade-up">
                <span class="inline-flex items-center gap-2 rounded-full border border-sage-300/70 bg-sage-100/70 px-4 py-1.5 text-xs font-medium text-sage-700 dark:border-sage-700/60 dark:bg-sage-900/40 dark:text-sage-300">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sage-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-sage-500"></span>
                    </span>
                    Disponible pour de nouveaux projets
                </span>

                <h1 class="mt-6 text-balance text-4xl font-semibold leading-tight tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl lg:text-6xl">
                    Sena Studio
                    <span class="block bg-gradient-to-r from-sage-700 via-sage-600 to-sage-500 bg-clip-text text-transparent dark:from-sage-300 dark:via-sage-400 dark:to-sage-500">
                        Développement web sur mesure
                    </span>
                </h1>

                <p class="mx-auto mt-6 max-w-xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                    Je conçois et développe des applications web, des SaaS et des backoffices élégants et performants,
                    portés par Laravel, Livewire et Filament — de l'idée jusqu'à la mise en production.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    @foreach (['Laravel', 'Livewire', 'Filament', 'Tailwind'] as $tech)
                        <span class="rounded-full border border-ink-200 bg-white/70 px-3 py-1 text-xs font-medium text-ink-600 dark:border-ink-700 dark:bg-ink-900/60 dark:text-ink-300">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <flux:button variant="primary" size="base" :href="route('projects.index')" wire:navigate class="rounded-xl">
                        Voir mes projets
                    </flux:button>
                    <flux:button variant="subtle" size="base" :href="route('contact')" wire:navigate class="rounded-xl border border-ink-300 dark:border-ink-700">
                        Discutons de votre projet
                    </flux:button>
                </div>

                <dl class="mt-12 grid max-w-md grid-cols-3 gap-6 border-t border-ink-200/80 pt-6 dark:border-ink-800/60">
                    <div>
                        <dt class="text-sm text-ink-500 dark:text-ink-400">Projets publics</dt>
                        <dd class="mt-1 text-2xl font-semibold text-sage-600 dark:text-sage-300">{{ $this->projectCount }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-ink-500 dark:text-ink-400">Expertises</dt>
                        <dd class="mt-1 text-2xl font-semibold text-sage-600 dark:text-sage-300">{{ $this->topSkills->count() }}+</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-ink-500 dark:text-ink-400">Sur mesure</dt>
                        <dd class="mt-1 text-2xl font-semibold text-sage-600 dark:text-sage-300">100%</dd>
                    </div>
                </dl>
            </div>

            {{-- Colonne photo --}}
            <div class="relative mx-auto w-full max-w-sm motion-safe:animate-fade-up [animation-delay:160ms] lg:max-w-none">
                <div class="pointer-events-none absolute -inset-10 rounded-[3rem] bg-gradient-to-br from-sage-300/60 via-sage-200/40 to-sage-400/30 blur-3xl dark:from-sage-500/25 dark:via-sage-600/10 dark:to-sage-400/20" aria-hidden="true"></div>

                <div class="relative rotate-2 rounded-[2.25rem] bg-gradient-to-br from-sage-300 via-sage-400 to-sage-700 p-1.5 shadow-2xl shadow-sage-500/20 transition-transform duration-500 hover:rotate-0 dark:from-sage-400/70 dark:via-sage-500/60 dark:to-sage-800">
                    <img
                        src="{{ asset('images/portrait.jpeg') }}"
                        alt="Portrait Sena Studio"
                        class="aspect-square w-full rounded-[1.8rem] bg-white object-cover dark:bg-ink-950"
                    />
                </div>

                <div class="absolute -left-4 top-8 flex items-center gap-2 rounded-2xl border border-ink-200/80 bg-white/90 px-4 py-2.5 shadow-lg shadow-ink-900/5 backdrop-blur motion-safe:animate-fade-up [animation-delay:400ms] dark:border-ink-700/80 dark:bg-ink-900/90">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sage-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-sage-500"></span>
                    </span>
                    <span class="text-xs font-medium text-ink-700 dark:text-ink-200">Disponible dès maintenant</span>
                </div>

                <div class="absolute -right-3 bottom-10 rounded-2xl border border-ink-200/80 bg-white/90 px-4 py-2.5 shadow-lg shadow-ink-900/5 backdrop-blur motion-safe:animate-fade-up [animation-delay:560ms] dark:border-ink-700/80 dark:bg-ink-900/90">
                    <div class="text-xs font-medium text-ink-700 dark:text-ink-200">Développement web, SaaS</div>
                    <div class="text-[0.7rem] text-ink-500 dark:text-ink-400">&amp; applications sur mesure</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== SERVICES ===================== --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-600 dark:text-sage-300">Ce que je fais</span>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">Des services pensés pour durer</h2>
            <p class="mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-400">
                Chaque mission démarre par une écoute approfondie : comprendre votre métier, vos contraintes et vos objectifs avant d'écrire la moindre ligne de code.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Application web', 'Sites et applications sur mesure, adaptatifs et rapides, construits autour de vos usages réels.', 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5'],
                ['SaaS & backoffices', 'Produits multi-locataires, interfaces d\'administration claires et tableaux de bord qui font gagner du temps.', 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
                ['APIs & intégrations', 'Webhooks, paiements, SSO, synchronisations : vos systèmes communiquent de façon fiable et sécurisée.', 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99'],
                ['Performance & évolution', 'Audit, refonte et optimisation : temps de chargement réduits, accessibilité et code durable.', 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941'],
            ] as [$title, $text, $icon])
                <div class="group relative overflow-hidden rounded-2xl border border-ink-200/80 bg-white/70 p-6 shadow-sm shadow-sage-500/5 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/60 hover:shadow-lg hover:shadow-sage-500/10 dark:border-ink-800 dark:bg-ink-900/50 dark:hover:border-sage-500/40">
                    <div class="pointer-events-none absolute -right-8 -top-8 size-24 rounded-full bg-sage-200/50 blur-2xl transition-opacity duration-300 group-hover:opacity-100 dark:bg-sage-500/10" aria-hidden="true"></div>
                    <span class="flex size-11 items-center justify-center rounded-xl bg-sage-100 text-sage-700 dark:bg-sage-500/15 dark:text-sage-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===================== MÉTHODE ===================== --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-600 dark:text-sage-300">Ma méthode</span>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">Un accompagnement simple et transparent</h2>
            <p class="mx-auto mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-400">
                Vous savez toujours où en est votre projet, avec des livraisons régulières et des décisions expliquées.
            </p>
        </div>

        <ol class="relative grid gap-6 lg:grid-cols-4">
            <div class="pointer-events-none absolute left-8 right-8 top-7 hidden border-t-2 border-dashed border-sage-300/70 lg:block dark:border-sage-700/50" aria-hidden="true"></div>

            @foreach ([
                ['Découverte & cadrage', 'Objectifs, périmètre, budget : je cerne vos besoins et pose des bases claires.', 'M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z'],
                ['Architecture & design', 'Structuration du code, modèle de données, interfaces pensées pour vos utilisateurs.', 'M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125'],
                ['Développement itératif', 'Fonctionnalité par fonctionnalité, avec des points d\'étape réguliers et testables.', 'M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636'],
                ['Suivi & évolution', 'Mise en production accompagnée, documentation et améliorations continues.', 'M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25'],
            ] as $index => [$title, $text, $icon])
                <li class="group relative flex flex-col rounded-2xl border border-ink-200/80 bg-white/70 p-6 pt-8 shadow-sm shadow-sage-500/5 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/60 hover:shadow-lg hover:shadow-sage-500/10 dark:border-ink-800 dark:bg-ink-900/50 dark:hover:border-sage-500/40">
                    <div class="flex items-center gap-3">
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-sage-400 to-sage-600 text-sm font-bold text-white shadow-md shadow-sage-500/25 dark:from-sage-300 dark:to-sage-500 dark:text-sage-950">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="flex size-11 items-center justify-center rounded-xl bg-sage-100 text-sage-700 dark:bg-sage-500/15 dark:text-sage-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                            </svg>
                        </span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== PROJETS RÉCENTS ===================== --}}
    @if ($this->featuredProjects->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-600 dark:text-sage-300">Portfolio</span>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">Projets récents</h2>
                    <p class="mt-2 text-ink-500 dark:text-ink-400">Une sélection de réalisations récentes.</p>
                </div>
                <a href="{{ route('projects.index') }}" wire:navigate class="hidden text-sm font-medium text-sage-600 transition-colors hover:text-sage-700 sm:block dark:text-sage-300 dark:hover:text-sage-200">
                    Tout voir →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($this->featuredProjects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" wire:navigate
                       class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200/80 bg-white/70 shadow-sm shadow-sage-500/5 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/60 hover:shadow-lg hover:shadow-sage-500/10 dark:border-ink-800 dark:bg-ink-900/50 dark:hover:border-sage-500/40">
                        <x-project-media :image="$project->image" :label="$project->name" />
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-4 flex items-center gap-2">
                                <span class="rounded-md bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-700 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
                                <span class="rounded-md bg-sage-100 px-2.5 py-1 text-xs font-medium text-sage-700 dark:bg-sage-500/15 dark:text-sage-300">{{ $project->status->label() }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-ink-900 transition-colors group-hover:text-sage-700 dark:text-ink-50 dark:group-hover:text-sage-300">
                                {{ $project->name }}
                            </h3>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                                {{ $project->description }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach ($project->skills->take(3) as $skill)
                                    <span class="rounded bg-ink-100/80 px-2 py-0.5 text-xs text-ink-600 dark:bg-ink-800/70 dark:text-ink-300">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            @if ($project->url)
                                <span class="mt-4 inline-flex items-center gap-1 text-xs font-medium text-sage-600 transition-colors group-hover:text-sage-700 dark:text-sage-300 dark:group-hover:text-sage-200">
                                    Voir le projet
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===================== EXPERTISES ===================== --}}
    @if ($this->topSkills->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-600 dark:text-sage-300">Compétences</span>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">Expertises</h2>
                    <p class="mt-2 text-ink-500 dark:text-ink-400">Compétences clés au service de vos projets.</p>
                </div>
                <a href="{{ route('skills.index') }}" wire:navigate class="hidden text-sm font-medium text-sage-600 transition-colors hover:text-sage-700 sm:block dark:text-sage-300 dark:hover:text-sage-200">
                    Toutes les compétences →
                </a>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($this->topSkills as $skill)
                    <a href="{{ route('skills.index') }}" wire:navigate
                       class="group flex items-center justify-between rounded-xl border border-ink-200/80 bg-white/70 px-5 py-4 shadow-sm shadow-sage-500/5 transition-all duration-300 hover:-translate-y-0.5 hover:border-sage-400/60 hover:shadow-md dark:border-ink-800 dark:bg-ink-900/50 dark:hover:border-sage-500/40">
                        <span class="flex items-center gap-2.5">
                            @if ($skill->icon)
                                <x-site-icon :icon="$skill->icon" class="size-5" />
                            @endif
                            <span class="font-medium text-ink-800 transition-colors group-hover:text-sage-700 dark:text-ink-100 dark:group-hover:text-sage-300">{{ $skill->name }}</span>
                        </span>
                        <span class="text-xs text-ink-500 dark:text-ink-500">{{ $skill->level->label() }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===================== STACK BAND ===================== --}}
    @if ($this->stackHighlights->isNotEmpty())
        <section class="border-y border-ink-200/80 bg-sage-100/50 dark:border-ink-800/60 dark:bg-ink-900/30">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="mb-8 text-center">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-600 dark:text-sage-300">Technologies</span>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">Stack technique</h2>
                    <p class="mt-2 text-ink-500 dark:text-ink-400">Les technologies que je maîtrise au quotidien.</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($this->stackHighlights as $category => $items)
                        <div class="rounded-2xl border border-ink-200/80 bg-white/70 p-6 shadow-sm shadow-sage-500/5 dark:border-ink-800 dark:bg-ink-900/50">
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-sage-600 dark:text-sage-300">{{ ucfirst($category) }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($items->take(3) as $item)
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-ink-100 px-2.5 py-1 text-xs text-ink-700 dark:bg-ink-800 dark:text-ink-200">
                                        @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                        {{ $item->value }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 text-center">
                    <a href="{{ route('stack.index') }}" wire:navigate class="text-sm font-medium text-sage-600 transition-colors hover:text-sage-700 dark:text-sage-300 dark:hover:text-sage-200">
                        Explorer toute la stack →
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== CTA ===================== --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border border-sage-800/20 bg-gradient-to-br from-sage-600 to-sage-800 p-10 text-center shadow-xl shadow-sage-700/20 dark:border-sage-500/30 sm:p-14">
            <div class="pointer-events-none absolute -top-20 left-1/2 h-64 w-96 -translate-x-1/2 animate-drift rounded-full bg-sage-300/20 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-0 bg-grid opacity-40 [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_70%)] dark:opacity-25" aria-hidden="true"></div>
            <h2 class="relative mx-auto max-w-2xl text-balance text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                Un projet en tête ?
            </h2>
            <p class="relative mx-auto mt-3 max-w-xl text-pretty text-sage-100">
                Discutons de vos objectifs et transformons votre idée en produit web fiable et élégant.
            </p>
            <div class="relative mt-8 flex flex-wrap items-center justify-center gap-4">
                <flux:button variant="primary" size="base" :href="route('contact')" wire:navigate class="rounded-xl bg-white text-sage-800 hover:bg-sage-50">
                    Démarrer la conversation
                </flux:button>
                <a href="{{ route('stack.index') }}" wire:navigate class="text-sm font-medium text-sage-100 underline-offset-4 transition-colors hover:text-white hover:underline">
                    Voir la stack technique
                </a>
            </div>
        </div>
    </section>
</div>
