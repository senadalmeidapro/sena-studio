<div class="public-page skills-page">

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

    <section class="skills-overview">
        <div>
            <p class="eyebrow">{{ __('skills.signal_title') }}</p>
            <p class="mt-2 max-w-md text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ __('skills.signal_text') }}</p>
        </div>
        @foreach ([__('skills.signal_backend'), __('skills.signal_data'), __('skills.signal_infra')] as $label)
            <div class="border-l border-ink-200 pl-4 dark:border-ink-700">
                <span class="block size-2 rounded-full bg-blue-500"></span>
                <p class="mt-3 text-sm font-medium text-ink-800 dark:text-ink-200">{{ $label }}</p>
            </div>
        @endforeach
    </section>

    <div class="skills-role-list">
        @foreach ($this->byRole as $roleKey => $skills)
            <section class="skill-group">
                <div class="skill-group-heading">
                    <h2>
                        {{ __('skills.role_'.$roleKey) }}
                    </h2>
                    <span class="hidden font-mono text-[0.7rem] uppercase tracking-[0.14em] text-ink-400 sm:block dark:text-ink-500">
                        {{ $skills->count() }} {{ $skills->count() > 1 ? __('skills.count_plural_unit') : __('skills.count_unit') }}
                    </span>
                    <span aria-hidden="true" class="hidden h-px min-w-8 flex-1 bg-ink-300 sm:block dark:bg-ink-700"></span>
                </div>

                <div class="skill-group-content">
                    @foreach ($skills as $skill)
                        <article id="{{ skill_anchor($skill->name) }}" class="skill-entry scroll-mt-28">
                            <div class="skill-entry-heading">
                                <div class="flex items-center gap-3">
                                    @if ($skill->icon)
                                        <x-site-icon :icon="$skill->icon" class="size-5 text-primary" />
                                    @endif
                                    <h3>{{ $skill->name }}</h3>
                                </div>
                                @if ($skill->projects->isNotEmpty())
                                    <span class="studio-meta">
                                        {{ $skill->projects->count() }} {{ $skill->projects->count() > 1 ? __('common.projects_count_plural_unit') : __('common.projects_count_unit') }}
                                    </span>
                                @endif
                            </div>
                            @if ($skill->description)
                                <p class="skill-entry-description">{{ $skill->description }}</p>
                            @endif

                            @if ($skill->projects->isNotEmpty())
                                <p class="skill-applied-label">{{ __('skills.applied_in') }}</p>
                            @endif
                            <div class="skill-projects">
                                @foreach ($skill->projects->take(3) as $project)
                                    <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate>
                                        {{ $project->name }}
                                    </a>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    @if ($this->byRole->isEmpty())
        <div class="mt-12 rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            {{ __('skills.empty') }}
        </div>
    @endif

</div>
