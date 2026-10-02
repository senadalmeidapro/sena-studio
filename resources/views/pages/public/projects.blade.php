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

    <section class="mt-10 grid gap-7 rounded-2xl border border-ink-200 bg-card p-6 shadow-soft dark:border-ink-700 sm:p-8 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] lg:items-center">
        <div>
            <p class="eyebrow">{{ __('projects.signal_title') }}</p>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-ink-600 dark:text-ink-300">{{ __('projects.signal_text') }}</p>
        </div>
        <dl class="grid grid-cols-3 divide-x divide-ink-200 border-t border-ink-200 pt-5 dark:divide-ink-700 dark:border-ink-700 lg:border-l lg:border-t-0 lg:pl-7 lg:pt-0">
            <div>
                <dd class="font-display text-2xl font-semibold tabular-nums tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">{{ $this->counts['all'] }}</dd>
                <dt class="mt-1 pr-2 text-[0.7rem] leading-snug text-ink-500 dark:text-ink-400 sm:text-xs">{{ __('projects.signal_total') }}</dt>
            </div>
            <div class="pl-3 sm:pl-5">
                <dd class="font-display text-2xl font-semibold tabular-nums tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">{{ $this->categories->count() }}</dd>
                <dt class="mt-1 pr-2 text-[0.7rem] leading-snug text-ink-500 dark:text-ink-400 sm:text-xs">{{ __('projects.signal_domains') }}</dt>
            </div>
            <div class="pl-3 sm:pl-5">
                <dd class="font-display text-2xl font-semibold tabular-nums tracking-tight text-ink-900 dark:text-ink-50 sm:text-3xl">{{ $this->skills->count() }}</dd>
                <dt class="mt-1 pr-1 text-[0.7rem] leading-snug text-ink-500 dark:text-ink-400 sm:text-xs">{{ __('projects.signal_skills') }}</dt>
            </div>
        </dl>
    </section>

    {{-- Filtres --}}
    <section class="mt-6 rounded-2xl border border-ink-200 bg-surface p-5 dark:border-ink-700 sm:p-6" aria-labelledby="project-filters-title">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h2 id="project-filters-title" class="font-display text-base font-semibold tracking-tight text-ink-900 dark:text-ink-50">{{ __('projects.filters_title') }}</h2>
                <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('projects.filters_help') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div x-data="{ selected: @js($this->type ?? 'all') }" role="group" aria-label="{{ __('projects.type_filter') }}" class="flex flex-wrap gap-2">
                    @foreach (['all' => ['label' => __('projects.filter_all'), 'count' => $this->counts['all']], 'web' => ['label' => __('projects.filter_web'), 'count' => $this->counts['web']], 'app' => ['label' => __('projects.filter_apps'), 'count' => $this->counts['app']], 'software' => ['label' => __('projects.filter_software'), 'count' => $this->counts['software']]] as $key => $filter)
                        <button
                            type="button"
                            wire:click="filterBy(@js($key === 'all' ? null : $key))"
                            x-on:click="selected = @js($key)"
                            :aria-pressed="selected === @js($key) ? 'true' : 'false'"
                            wire:loading.attr="disabled"
                            wire:target="filterBy"
                            class="inline-flex min-h-10 cursor-pointer items-center gap-2 rounded-lg border px-3.5 py-2 text-sm font-medium transition-all hover:-translate-y-px hover:shadow-soft active:scale-[0.98] disabled:cursor-wait disabled:opacity-60"
                            :class="selected === @js($key) ? 'border-blue-600 bg-blue-600 font-semibold text-white shadow-soft dark:border-blue-500 dark:bg-blue-500 dark:text-blue-950' : 'border-ink-200 bg-card text-ink-600 hover:border-blue-300 hover:bg-white hover:text-ink-900 dark:border-ink-700 dark:bg-card dark:text-ink-300 dark:hover:border-blue-500/60 dark:hover:bg-ink-800 dark:hover:text-ink-50'"
                        >
                            {{ $filter['label'] }} <span class="rounded-full bg-black/5 px-1.5 py-0.5 font-mono text-[0.65rem] tabular-nums opacity-80 dark:bg-white/10">{{ $filter['count'] }}</span>
                        </button>
                    @endforeach
                </div>
                <span wire:loading.flex wire:target="filterBy" role="status" aria-live="polite" class="items-center gap-2 text-sm text-ink-500 dark:text-ink-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="size-4 animate-spin" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" />
                    </svg>
                    {{ __('projects.filter_loading') }}
                </span>
                @if (filled($type) || filled($category) || filled($skill))
                    <button type="button" wire:click="clearFilters" class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg px-3 text-sm font-medium text-blue-700 underline decoration-blue-300 underline-offset-4 transition-colors hover:bg-blue-50 hover:text-blue-900 dark:text-blue-300 dark:decoration-blue-700 dark:hover:bg-blue-950/40 dark:hover:text-blue-100">
                        {{ __('projects.reset') }}
                    </button>
                @endif
            </div>
        </div>
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
                        @if ($project->result_metric)
                            <p class="mt-2 font-semibold text-blue-700 dark:text-blue-300">{{ $project->result_metric }}</p>
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
