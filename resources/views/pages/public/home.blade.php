<div class="space-y-24 pb-24 sm:space-y-32">

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid [mask-image:radial-gradient(ellipse_at_top,black_30%,transparent_72%)]" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 pt-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20 lg:px-8 lg:pt-28">
            {{-- Colonne texte --}}
            <div class="motion-safe:animate-fade-up">
                <div class="flex items-center gap-3">
                    <span class="text-[0.7rem] font-medium tabular-nums text-ink-400 dark:text-ink-500">01</span>
                    <span class="text-ink-300 dark:text-ink-600">/</span>
                    <span class="eyebrow">Studio indépendant — Lyon, France</span>
                </div>

                <h1 class="mt-7 font-display text-5xl font-medium leading-[1.02] tracking-tight text-ink-900 dark:text-ink-50 sm:text-6xl lg:text-7xl">
                    Sena Studio
                    <span class="mt-1 block text-emerald-600 dark:text-emerald-400">
                        Développement web sur mesure
                    </span>
                </h1>

                <p class="mt-7 max-w-xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                    Je conçois et développe des applications web, des SaaS et des backoffices élégants et performants,
                    portés par Laravel, Livewire et Filament — de l'idée jusqu'à la mise en production.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-2">
                    @foreach (['Laravel', 'Livewire', 'Filament', 'Tailwind'] as $tech)
                        <span class="rounded-full border border-ink-300 px-3 py-1 font-mono text-[0.7rem] uppercase tracking-[0.12em] text-ink-600 dark:border-ink-700 dark:text-ink-300">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-6">
                    <a href="{{ route('projects.index') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-full bg-emerald-600 px-7 py-3.5 font-display text-base font-medium text-white transition-colors hover:bg-emerald-700 dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400">
                        Voir mes projets
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <x-front.arrow-link :href="route('contact')" wire:navigate>
                        Discutons de votre projet
                    </x-front.arrow-link>
                </div>

                <dl class="mt-14 grid max-w-xl grid-cols-3 gap-8 border-t border-ink-300 pt-6 dark:border-ink-700">
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">Projets publics</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">{{ $this->projectCount }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">Expertises</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">{{ $this->topSkills->count() }}+</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">Sur mesure</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">100%</dd>
                    </div>
                </dl>
            </div>

            {{-- Colonne photo --}}
            <div class="relative mx-auto w-full max-w-sm motion-safe:animate-fade-up [animation-delay:160ms] lg:max-w-none">
                <div class="crop-frame">
                    <div class="relative rotate-2 rounded-[2rem] bg-emerald-500 p-1.5 transition-transform duration-500 hover:rotate-0">
                        <img
                            src="{{ asset('images/portrait.jpeg') }}"
                            alt="Portrait Sena Studio"
                            class="aspect-square w-full rounded-[1.6rem] bg-white object-cover dark:bg-[#0a0a0a]"
                        />
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between gap-4">
                    <span class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-400 dark:text-ink-500">FIG. 01 — Portrait</span>
                    <span class="flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.16em] text-emerald-600 dark:text-emerald-400">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                        </span>
                        Disponible
                    </span>
                </div>

                <div class="mt-6 rounded-2xl border border-ink-300 bg-white px-5 py-4 dark:border-ink-700 dark:bg-[#141414]">
                    <div class="flex items-center gap-2 text-sm font-medium text-ink-800 dark:text-ink-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-emerald-600 dark:text-emerald-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Web, SaaS &amp; sur mesure
                    </div>
                    <div class="mt-1 pl-6 font-mono text-[0.68rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">Laravel · Livewire · Filament</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== 01 — SERVICES ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            index="01"
            label="Ce que je fais"
            title="Des services pensés pour durer"
            subtitle="Chaque mission démarre par une écoute approfondie : comprendre votre métier, vos contraintes et vos objectifs avant d'écrire la moindre ligne de code."
        />

        <ol class="divide-y divide-ink-300 border-y border-ink-300 dark:divide-ink-700 dark:border-ink-700">
            @foreach ([
                ['Application web', 'Sites et applications sur mesure, adaptatifs et rapides, construits autour de vos usages réels.', 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5'],
                ['SaaS & backoffices', 'Produits multi-locataires, interfaces d\'administration claires et tableaux de bord qui font gagner du temps.', 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
                ['APIs & intégrations', 'Webhooks, paiements, SSO, synchronisations : vos systèmes communiquent de façon fiable et sécurisée.', 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99'],
                ['Performance & évolution', 'Audit, refonte et optimisation : temps de chargement réduits, accessibilité et code durable.', 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941'],
            ] as $i => [$title, $text, $icon])
                <li class="group grid gap-2 py-8 transition-colors hover:bg-emerald-50/50 sm:grid-cols-[3.5rem_3.5rem_1fr] sm:items-start sm:gap-6 sm:px-4 sm:py-10 dark:hover:bg-emerald-950/20">
                    <span class="pt-1 font-mono text-xs tabular-nums text-ink-400 transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-400">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="flex size-11 items-center justify-center rounded-xl bg-ink-100 text-ink-700 transition-colors group-hover:bg-emerald-500 group-hover:text-white dark:bg-ink-800 dark:text-ink-200 dark:group-hover:bg-emerald-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </span>
                    <div class="grid gap-1 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-baseline sm:gap-8">
                        <div>
                            <h3 class="font-display text-xl font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                        </div>
                        <span class="hidden max-w-xs justify-end pt-1 font-medium text-emerald-600 opacity-0 transition-all duration-300 group-hover:opacity-100 sm:flex dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5 -rotate-45 transition-transform duration-300 group-hover:rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </span>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== 02 — MÉTHODE ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            index="02"
            label="Ma méthode"
            title="Un accompagnement simple et transparent"
            subtitle="Vous savez toujours où en est votre projet, avec des livraisons régulières et des décisions expliquées."
            align="center"
        />

        <ol class="grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300/80 sm:grid-cols-2 lg:grid-cols-4 dark:border-ink-700 dark:bg-ink-700/60">
            @foreach ([
                ['Découverte & cadrage', 'Objectifs, périmètre, budget : je cerne vos besoins et pose des bases claires.'],
                ['Architecture & design', 'Structuration du code, modèle de données, interfaces pensées pour vos utilisateurs.'],
                ['Développement itératif', 'Fonctionnalité par fonctionnalité, avec des points d\'étape réguliers et testables.'],
                ['Suivi & évolution', 'Mise en production accompagnée, documentation et améliorations continues.'],
            ] as $i => [$title, $text])
                <li class="group flex flex-col gap-3 bg-white p-7 transition-colors hover:bg-emerald-50/60 sm:p-8 dark:bg-ink-950 dark:hover:bg-emerald-950/20">
                    <span class="font-display text-4xl font-medium text-emerald-600/80 transition-colors group-hover:text-emerald-600 dark:text-emerald-400/80 dark:group-hover:text-emerald-400">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h3 class="font-display text-lg font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                    <p class="text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== 03 — PORTFOLIO ===================== --}}
    @if ($this->featuredProjects->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-front.section-heading
                index="03"
                label="Portfolio"
                title="Projets récents"
                subtitle="Une sélection de réalisations récentes."
                actionHref="{{ route('projects.index') }}"
                actionLabel="Tout voir"
            />

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($this->featuredProjects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" wire:navigate
                       class="group flex flex-col overflow-hidden rounded-2xl border border-ink-300 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-emerald-400/60 dark:border-ink-700 dark:bg-ink-900 dark:hover:border-emerald-500/40">
                        <x-project-media :image="$project->image" :label="$project->name" />
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-4 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
                                <span class="rounded-md bg-ink-100 px-2 py-1 text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
                                <span class="rounded-md bg-emerald-100 px-2 py-1 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">{{ $project->status->label() }}</span>
                            </div>
                            <h3 class="font-display text-xl font-medium tracking-tight text-ink-900 transition-colors group-hover:text-emerald-700 dark:text-ink-50 dark:group-hover:text-emerald-300">
                                {{ $project->name }}
                            </h3>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                                {{ $project->description }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-1.5 font-mono text-[0.68rem] uppercase tracking-[0.08em]">
                                @foreach ($project->skills->take(3) as $skill)
                                    <span class="rounded bg-ink-100/80 px-2 py-0.5 text-ink-600 dark:bg-ink-800/70 dark:text-ink-300">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            @if ($project->url)
                                <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-emerald-600 transition-colors group-hover:text-emerald-700 dark:text-emerald-300 dark:group-hover:text-emerald-200">
                                    Voir le projet
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         class="size-4 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
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

    {{-- ===================== 04 — EXPERTISES ===================== --}}
    @if ($this->topSkills->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-front.section-heading
                index="04"
                label="Compétences"
                title="Expertises"
                subtitle="Compétences clés au service de vos projets."
                actionHref="{{ route('skills.index') }}"
                actionLabel="Toutes les compétences"
            />

            <ul class="divide-y divide-ink-300 border-y border-ink-300 dark:divide-ink-700 dark:border-ink-700">
                @foreach ($this->topSkills as $skill)
                    <li>
                        <a href="{{ route('skills.index') }}" wire:navigate
                           class="group flex items-center justify-between gap-4 py-4 transition-colors hover:bg-emerald-50/50 dark:hover:bg-emerald-950/20">
                            <span class="flex items-center gap-3.5">
                                @if ($skill->icon)
                                    <x-site-icon :icon="$skill->icon" class="size-5 text-ink-400 transition-colors group-hover:text-emerald-600 dark:text-ink-500 dark:group-hover:text-emerald-400" />
                                @endif
                                <span class="font-display text-lg font-medium tracking-tight text-ink-900 transition-colors group-hover:text-emerald-700 dark:text-ink-50 dark:group-hover:text-emerald-300">{{ $skill->name }}</span>
                            </span>
                            <span class="hidden font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 sm:block dark:text-ink-500">{{ $skill->level->label() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- ===================== 05 — STACK (bande marquee) ===================== --}}
    @if ($this->stackHighlights->isNotEmpty())
        <section class="border-y border-ink-300 bg-emerald-50 dark:border-ink-700 dark:bg-ink-900">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <x-front.section-heading
                    index="05"
                    label="Technologies"
                    title="Stack technique"
                    subtitle="Les technologies que je maîtrise au quotidien."
                    align="center"
                />
            </div>

            <div class="relative overflow-hidden border-t border-ink-300 py-5 dark:border-ink-700">
                <div class="flex w-max animate-marquee items-center gap-10">
                    @foreach ([0, 1] as $copy)
                        <div class="flex items-center gap-10" aria-hidden="{{ $copy === 1 ? 'true' : 'false' }}">
                            @foreach ($this->stackHighlights as $category => $items)
                                @foreach ($items as $item)
                                    <span class="flex items-center gap-10 font-display text-2xl tracking-tight text-ink-800 dark:text-ink-100">
                                        {{ $item->value }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-emerald-500">
                                            <path d="M12 .5 14.6 9.4 23.5 12l-8.9 2.6L12 23.5 9.4 14.6.5 12l8.9-2.6Z" />
                                        </svg>
                                    </span>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:justify-center lg:gap-10 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($this->stackHighlights as $category => $items)
                        <div>
                            <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-300">{{ ucfirst($category) }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($items->take(3) as $item)
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-white px-2.5 py-1 font-mono text-[0.7rem] uppercase tracking-[0.08em] text-ink-700 dark:bg-ink-950 dark:text-ink-200">
                                        @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                        {{ $item->value }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-front.arrow-link :href="route('stack.index')" wire:navigate class="shrink-0">
                    Explorer toute la stack
                </x-front.arrow-link>
            </div>
        </section>
    @endif

    {{-- ===================== 06 — CTA ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-emerald-600 px-8 py-14 text-center sm:px-14 sm:py-20">
            <div class="pointer-events-none absolute inset-0 bg-grid opacity-40 [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_70%)] dark:opacity-25" aria-hidden="true"></div>

            <div class="relative">
                <span class="font-mono text-[0.7rem] uppercase tracking-[0.25em] text-emerald-200">06 — Contact</span>
                <h2 class="mx-auto mt-4 max-w-2xl font-display text-3xl font-medium tracking-tight text-white sm:text-5xl">
                    Un projet en tête&nbsp;?
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-pretty text-emerald-100">
                    Discutons de vos objectifs et transformons votre idée en produit web fiable et élégant.
                </p>
                <div class="mt-9 flex flex-wrap items-center justify-center gap-6">
                    <a href="{{ route('contact') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-full bg-white px-7 py-3.5 font-display text-base font-medium text-emerald-700 transition-colors hover:bg-emerald-50 dark:text-emerald-800 dark:hover:bg-emerald-100">
                        Démarrer la conversation
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('stack.index') }}" wire:navigate class="font-medium text-emerald-100 underline-offset-4 transition-colors hover:text-white hover:underline">
                        Voir la stack technique
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>