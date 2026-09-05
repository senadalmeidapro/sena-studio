<div class="mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">01</span>
            <span class="eyebrow">Portfolio</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            Projets
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            Une sélection de réalisations : applications web, SaaS et solutions logicielles conçues avec le souci du détail et de la performance.
        </p>
    </header>

    {{-- Filtres --}}
    <div class="sticky top-16 z-20 -mx-4 mt-8 border-b border-ink-300 bg-white/90 px-4 backdrop-blur-sm sm:mx-0 sm:px-0 dark:border-ink-700 dark:bg-ink-950/90">
        <div class="flex flex-wrap gap-6">
            @foreach (['all' => ['label' => 'Tous', 'count' => $this->counts['all']], 'web' => ['label' => 'Web', 'count' => $this->counts['web']], 'app' => ['label' => 'Applications', 'count' => $this->counts['app']], 'software' => ['label' => 'Logiciels', 'count' => $this->counts['software']]] as $key => $filter)
                <button
                    type="button"
                    wire:click="filterBy(@js($key === 'all' ? null : $key))"
                    class="group -mb-px flex items-center gap-2 border-b-2 pb-3.5 font-mono text-[0.72rem] uppercase tracking-[0.14em] transition-colors"
                    @class([
                        'border-emerald-500 text-emerald-700 dark:border-emerald-400 dark:text-emerald-300' => ($this->type ?? 'all') === $key,
                        'border-transparent text-ink-500 hover:border-ink-300 hover:text-ink-800 dark:text-ink-400 dark:hover:border-ink-600 dark:hover:text-ink-100' => ($this->type ?? 'all') !== $key,
                    ])
                >
                    {{ $filter['label'] }}
                    <span class="font-mono text-[0.62rem] tabular-nums opacity-70">{{ $this->counts[$key] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Grille --}}
    @if ($this->projects->isNotEmpty())
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" wire:navigate
                   class="group flex flex-col overflow-hidden rounded-2xl border border-ink-300 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-emerald-400/60 dark:border-ink-700 dark:bg-ink-950 dark:hover:border-emerald-500/40">
                    <x-project-media :image="$project->image" :label="$project->name" />
                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-4 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
                            <span class="rounded-md bg-ink-100 px-2 py-1 text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
                            <span class="rounded-md bg-emerald-100 px-2 py-1 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">{{ $project->status->label() }}</span>
                        </div>
                        <h2 class="font-display text-xl font-medium tracking-tight text-ink-900 transition-colors group-hover:text-emerald-700 dark:text-ink-50 dark:group-hover:text-emerald-300">
                            {{ $project->name }}
                        </h2>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                            {{ $project->description }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($project->skills->take(3) as $skill)
                                <span class="rounded bg-ink-100/80 px-2 py-0.5 font-mono text-[0.68rem] uppercase tracking-[0.08em] text-ink-600 dark:bg-ink-800/70 dark:text-ink-300">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                        @if ($project->url)
                            <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-emerald-600 transition-colors group-hover:text-emerald-700 dark:text-emerald-300 dark:group-hover:text-emerald-200">
                                Voir le projet
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-14">
            {{ $this->projects->links() }}
        </div>
    @else
        <div class="mt-12 rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            Aucun projet dans cette catégorie pour le moment.
        </div>
    @endif
</div>