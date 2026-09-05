<div class="mx-auto max-w-6xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">

    <header class="mb-12 motion-safe:animate-fade-up">
        <h1 class="text-balance text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">Projets</h1>
        <p class="mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-300">
            Une sélection de réalisations : applications web, SaaS et solutions logicielles conçues avec le souci du détail et de la performance.
        </p>
    </header>

    {{-- Filters --}}
    <div class="mb-8 flex flex-wrap gap-2">
        @php
            $filters = [
                'all' => ['label' => 'Tous', 'count' => $this->counts['all']],
                'web' => ['label' => 'Web', 'count' => $this->counts['web']],
                'app' => ['label' => 'Applications', 'count' => $this->counts['app']],
                'software' => ['label' => 'Logiciels', 'count' => $this->counts['software']],
            ];
        @endphp
        @foreach ($filters as $key => ['label' => $label])
            <button
                wire:click="filterBy(@js($key === 'all' ? null : $key))"
                @class([
                    'rounded-full border px-4 py-2 text-sm font-medium transition-all duration-200',
                    'border-sage-500 bg-sage-500/10 text-sage-700 dark:border-sage-400 dark:bg-sage-500/15 dark:text-sage-300' => ($this->type ?? 'all') === $key,
                    'border-ink-300 bg-white/70 text-ink-600 hover:border-ink-500 hover:text-ink-900 dark:border-ink-700 dark:bg-ink-900/50 dark:text-ink-300 dark:hover:border-ink-500 dark:hover:text-ink-100' => ($this->type ?? 'all') !== $key,
                ])
            >
                {{ $label }} <span class="ml-1 text-xs opacity-70">{{ $this->counts[$key] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Grid --}}
    @if ($this->projects->isNotEmpty())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" wire:navigate
                   class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200/80 bg-white/70 shadow-sm shadow-sage-500/5 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/60 hover:shadow-lg hover:shadow-sage-500/10 dark:border-ink-800 dark:bg-ink-900/50 dark:hover:border-sage-500/40">
                    <x-project-media :image="$project->image" :label="$project->name" />
                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-4 flex items-center gap-2">
                            <span class="rounded-md bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-700 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
                            <span class="rounded-md bg-sage-100 px-2.5 py-1 text-xs font-medium text-sage-700 dark:bg-sage-500/15 dark:text-sage-300">{{ $project->status->label() }}</span>
                        </div>
                        <h2 class="text-lg font-semibold text-ink-900 transition-colors group-hover:text-sage-700 dark:text-ink-50 dark:group-hover:text-sage-300">
                            {{ $project->name }}
                        </h2>
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

        <div class="mt-10">
            {{ $this->projects->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            Aucun projet dans cette catégorie pour le moment.
        </div>
    @endif
</div>