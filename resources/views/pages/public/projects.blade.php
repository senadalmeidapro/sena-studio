<div class="public-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div>
            <span class="eyebrow">{{ __('projects.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('projects.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('projects.subtitle') }}
        </p>
    </header>

    <section class="mt-10 grid gap-8 border-y border-ink-300 py-8 dark:border-ink-700 lg:grid-cols-[1.2fr_1fr] lg:items-center">
        <div>
            <p class="eyebrow">{{ __('projects.signal_title') }}</p>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ __('projects.signal_text') }}</p>
        </div>
        <dl class="grid grid-cols-3 gap-4 border-t border-ink-200 pt-5 dark:border-ink-700 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0">
            <div>
                <dd class="font-display text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ $this->counts['all'] }}</dd>
                <dt class="mt-1 text-xs leading-snug text-ink-500 dark:text-ink-400">{{ __('projects.signal_total') }}</dt>
            </div>
            <div>
                <dd class="font-display text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ $this->categories->count() }}</dd>
                <dt class="mt-1 text-xs leading-snug text-ink-500 dark:text-ink-400">{{ __('projects.signal_domains') }}</dt>
            </div>
            <div>
                <dd class="font-display text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ $this->skills->count() }}</dd>
                <dt class="mt-1 text-xs leading-snug text-ink-500 dark:text-ink-400">{{ __('projects.signal_skills') }}</dt>
            </div>
        </dl>
    </section>

    {{-- Filtres --}}
    <section class="sticky top-16 z-20 -mx-4 mt-8 border-b border-ink-300 bg-canvas/95 px-4 backdrop-blur-sm sm:mx-0 sm:px-0 dark:border-ink-700 dark:bg-canvas/95" aria-labelledby="project-filters-title">
        <div class="flex flex-col gap-4 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 id="project-filters-title" class="font-display text-sm font-semibold text-ink-900 dark:text-ink-50">{{ __('projects.filters_title') }}</h2>
                <p class="mt-1 text-xs text-ink-500 dark:text-ink-400">{{ __('projects.signal_text') }}</p>
            </div>
            <div class="flex flex-wrap gap-1 rounded-lg border border-ink-300 bg-card p-1 dark:border-ink-700">
                @foreach (['all' => ['label' => __('projects.filter_all'), 'count' => $this->counts['all']], 'web' => ['label' => __('projects.filter_web'), 'count' => $this->counts['web']], 'app' => ['label' => __('projects.filter_apps'), 'count' => $this->counts['app']], 'software' => ['label' => __('projects.filter_software'), 'count' => $this->counts['software']]] as $key => $filter)
                    <button
                        type="button"
                        wire:click="filterBy(@js($key === 'all' ? null : $key))"
                        aria-pressed="{{ ($this->type ?? 'all') === $key ? 'true' : 'false' }}"
                        class="rounded-md px-3 py-2 text-sm transition-colors"
                        @class([
                            'bg-blue-600 font-semibold text-white dark:bg-blue-500 dark:text-blue-950' => ($this->type ?? 'all') === $key,
                            'text-ink-600 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-300 dark:hover:bg-ink-800 dark:hover:text-ink-50' => ($this->type ?? 'all') !== $key,
                        ])
                    >
                        {{ $filter['label'] }} <span class="ml-1 text-xs opacity-70">{{ $filter['count'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="grid gap-3 border-t border-ink-200 py-4 dark:border-ink-700 sm:grid-cols-2">
            <label class="grid gap-1.5 text-sm font-medium text-ink-700 dark:text-ink-200">
                {{ __('projects.domains') }}
                <select wire:change="filterByCategory($event.target.value || null)" class="rounded-lg border border-ink-300 bg-card px-3 py-2.5 text-sm text-ink-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-ink-700 dark:text-ink-100">
                    <option value="">{{ __('projects.all_domains') }}</option>
                    @foreach ($this->categories as $cat)
                        <option value="{{ $cat->slug }}" @selected($category === $cat->slug)>{{ $cat->name }} ({{ $cat->projects_count }})</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-1.5 text-sm font-medium text-ink-700 dark:text-ink-200">
                {{ __('projects.skills_filter') }}
                <select wire:change="filterBySkill($event.target.value || null)" class="rounded-lg border border-ink-300 bg-card px-3 py-2.5 text-sm text-ink-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-ink-700 dark:text-ink-100">
                    <option value="">{{ __('projects.all_skills') }}</option>
                    @foreach ($this->skills as $skillItem)
                        <option value="{{ $skillItem->slug }}" @selected($skill === $skillItem->slug)>{{ $skillItem->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        @if (filled($type) || filled($category) || filled($skill))
            <button type="button" wire:click="clearFilters" class="mb-4 inline-flex items-center gap-1.5 text-sm font-medium text-blue-700 transition-colors hover:text-blue-900 dark:text-blue-300 dark:hover:text-blue-100">
                {{ __('projects.reset') }}
            </button>
        @endif
    </section>

    {{-- Grille --}}
    @if ($this->projects->isNotEmpty())
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->projects as $project)
                <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate
                   class="group flex flex-col overflow-hidden rounded-xl border border-ink-300 bg-card transition-all duration-300 hover:-translate-y-1 hover:border-blue-400/70 hover:shadow-card dark:border-ink-700 dark:hover:border-blue-500/50">
                    <x-project-media :image="$project->image" :label="$project->name" />
                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-4 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
                            <span class="rounded-md bg-ink-100 px-2 py-1 text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
                            @php
                                $statusTone = match ($project->status) {
                                    \App\Enums\ProjectStatus::Production => ['bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300'],
                                    \App\Enums\ProjectStatus::Testing => ['bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300'],
                                    \App\Enums\ProjectStatus::Development => ['bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300'],
                                    \App\Enums\ProjectStatus::Cancelled => ['bg-ink-100 text-ink-500 dark:bg-ink-800/70 dark:text-ink-400'],
                                };
                            @endphp
                            <span class="rounded-md px-2 py-1 {{ $statusTone[0] }}">{{ $project->status->label() }}</span>
                        </div>
                        <h2 class="font-display text-xl font-medium tracking-tight text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">
                            {{ $project->name }}
                        </h2>
                        @if ($project->role)
                            <p class="mt-1 font-mono text-[0.66rem] uppercase tracking-[0.1em] text-blue-700 dark:text-blue-300">{{ $project->role }}</p>
                        @endif
                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                            {{ $project->description }}
                        </p>
                        @if ($project->problem || $project->result)
                            <dl class="mt-4 grid gap-3 border-t border-ink-200 pt-4 text-sm leading-relaxed dark:border-ink-700">
                                @if ($project->problem)
                                    <div>
                                        <dt class="font-mono text-[0.62rem] uppercase tracking-[0.12em] text-ink-500 dark:text-ink-400">{{ __('project.case_study_problem') }}</dt>
                                        <dd class="mt-1 line-clamp-2 text-ink-700 dark:text-ink-200">{{ $project->problem }}</dd>
                                    </div>
                                @endif
                                @if ($project->result)
                                    <div>
                                        <dt class="font-mono text-[0.62rem] uppercase tracking-[0.12em] text-ink-500 dark:text-ink-400">{{ __('project.case_study_result') }}</dt>
                                        <dd class="mt-1 line-clamp-2 text-ink-700 dark:text-ink-200">{{ $project->result }}</dd>
                                    </div>
                                @endif
                            </dl>
                        @endif
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($project->skills->take(3) as $skill)
                                <span class="rounded bg-ink-100/80 px-2 py-0.5 font-mono text-[0.68rem] uppercase tracking-[0.08em] text-ink-600 dark:bg-ink-800/70 dark:text-ink-300">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                        @if ($project->url)
                            <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-blue-600 transition-colors group-hover:text-blue-700 dark:text-blue-300 dark:group-hover:text-blue-200">
                                {{ __('common.view_project') }}
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
            {{ __('projects.empty') }}
        </div>
    @endif
</div>
