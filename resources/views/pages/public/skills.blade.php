<div class="mx-auto max-w-6xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">

    <header class="mb-12 motion-safe:animate-fade-up">
        <h1 class="text-balance text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">Compétences</h1>
        <p class="mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-300">
            Un aperçu de mes expertises, classées par niveau de maîtrise.
        </p>
    </header>

    <div class="space-y-12">
        @foreach ($this->byLevel as $levelKey => $skills)
            <section>
                <div class="mb-5 flex items-center gap-3">
                    <span class="flex size-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                    <h2 class="text-xl font-semibold text-ink-900 dark:text-ink-50">{{ \App\Enums\SkillLevel::from($levelKey)->label() }}</h2>
                    <span class="text-sm text-ink-500 dark:text-ink-500">{{ $skills->count() }} compétence{{ $skills->count() > 1 ? 's' : '' }}</span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills as $skill)
                        <div class="flex flex-col rounded-2xl border border-ink-200/80 bg-white p-6 shadow-sm shadow-emerald-500/5 transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-400/60 hover:shadow-md dark:border-ink-800 dark:bg-ink-900 dark:hover:border-emerald-500/40">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    @if ($skill->icon)
                                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-500/15">
                                            <x-site-icon :icon="$skill->icon" class="size-6" />
                                        </span>
                                    @endif
                                    <h3 class="text-base font-semibold text-ink-900 dark:text-ink-50">{{ $skill->name }}</h3>
                                </div>
                                @if ($skill->projects->isNotEmpty())
                                    <span class="shrink-0 rounded-md bg-ink-100 px-2 py-0.5 text-xs text-ink-500 dark:bg-ink-800 dark:text-ink-400">
                                        {{ $skill->projects->count() }} projet{{ $skill->projects->count() > 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </div>
                            @if ($skill->description)
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $skill->description }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach ($skill->projects->take(3) as $project)
                                    <a href="{{ route('projects.show', $project->slug) }}" wire:navigate
                                       class="rounded bg-ink-100/80 px-2 py-0.5 text-xs text-ink-600 transition-colors hover:text-emerald-700 dark:bg-ink-800/70 dark:text-ink-300 dark:hover:text-emerald-300">
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
        <div class="rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            Aucune compétence publiée pour le moment.
        </div>
    @endif
</div>