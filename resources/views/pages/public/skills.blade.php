<div class="mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('skills.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('skills.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('skills.subtitle') }}
        </p>
    </header>

    <div class="mt-12 space-y-16">
        @foreach ($this->byLevel as $levelKey => $skills)
            <section>
                <div class="mb-6 flex items-baseline gap-4">
                    <span class="font-mono text-[0.7rem] tabular-nums text-ink-400 dark:text-ink-500">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
                        {{ \App\Enums\SkillLevel::from($levelKey)->label() }}
                    </h2>
                    <span class="hidden font-mono text-[0.7rem] uppercase tracking-[0.14em] text-ink-400 sm:block dark:text-ink-500">
                        {{ $skills->count() }} {{ $skills->count() > 1 ? __('skills.count_plural_unit') : __('skills.count_unit') }}
                    </span>
                    <span aria-hidden="true" class="hidden h-px min-w-8 flex-1 bg-ink-300 sm:block dark:bg-ink-700"></span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills as $skill)
                        <div class="group flex flex-col rounded-2xl border border-ink-300 bg-card p-6 shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-400/60 hover:shadow-card dark:border-ink-700 dark:hover:border-blue-500/40">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    @if ($skill->icon)
                                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700 transition-colors group-hover:bg-blue-500 group-hover:text-white dark:bg-blue-500/15 dark:text-blue-300 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                                            <x-site-icon :icon="$skill->icon" class="size-6" />
                                        </span>
                                    @endif
                                    <h3 class="font-display text-lg font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $skill->name }}</h3>
                                </div>
                                @if ($skill->projects->isNotEmpty())
                                    <span class="shrink-0 font-mono text-[0.68rem] uppercase tracking-[0.1em] text-ink-500 dark:text-ink-400">
                                        {{ $skill->projects->count() }} {{ $skill->projects->count() > 1 ? __('common.projects_count_plural_unit') : __('common.projects_count_unit') }}
                                    </span>
                                @endif
                            </div>
                            @if ($skill->description)
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $skill->description }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach ($skill->projects->take(3) as $project)
                                    <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate
                                       class="rounded bg-ink-100/80 px-2 py-0.5 font-mono text-[0.68rem] uppercase tracking-[0.08em] text-ink-600 transition-colors hover:text-blue-700 dark:bg-ink-700/70 dark:text-ink-300 dark:hover:text-blue-300">
                                        {{ $project->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    @if ($this->byLevel->isEmpty())
        <div class="mt-12 rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            {{ __('skills.empty') }}
        </div>
    @endif
</div>