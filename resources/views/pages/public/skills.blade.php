<div class="public-page skills-page mx-auto">

    {{-- En-tête éditorial --}}
    <header class="skills-hero">
        <span class="eyebrow">{{ __('skills.eyebrow') }}</span>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('skills.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('skills.subtitle') }}
        </p>
    </header>

    <section class="skill-signal-map" aria-labelledby="skills-signal-title">
        <div class="skill-signal-intro">
            <p id="skills-signal-title" class="eyebrow">{{ __('skills.signal_title') }}</p>
            <p>{{ __('skills.signal_text') }}</p>
        </div>
        <div class="skill-signal-flow">
            <svg viewBox="0 0 600 60" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path d="M12 30h576" />
                <path d="M120 30h180m0 0h180" />
            </svg>
            @foreach ([__('skills.signal_backend'), __('skills.signal_data'), __('skills.signal_infra')] as $label)
                <div class="skill-signal-node">
                    <span aria-hidden="true"></span>
                    <p>{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <div class="skills-index">
        @foreach ($this->byRole as $roleKey => $skills)
            <section class="skills-group" aria-labelledby="skills-role-{{ $roleKey }}">
                <div class="skills-group-heading">
                    <h2 id="skills-role-{{ $roleKey }}" class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
                        {{ __('skills.role_'.$roleKey) }}
                    </h2>
                    <span class="skills-group-count">
                        {{ $skills->count() }} {{ $skills->count() > 1 ? __('skills.count_plural_unit') : __('skills.count_unit') }}
                    </span>
                    <span aria-hidden="true" class="skills-group-rule"></span>
                </div>

                <div class="skills-group-grid">
                    @foreach ($skills as $skill)
                        <article id="{{ skill_anchor($skill->name) }}" class="skill-entry scroll-mt-28">
                            <div class="skill-entry-heading">
                                @if ($skill->icon)
                                    <span class="skill-entry-icon" aria-hidden="true">
                                        <x-site-icon :icon="$skill->icon" class="size-6" />
                                    </span>
                                @endif
                                <h3>{{ $skill->name }}</h3>
                                @if ($skill->projects->isNotEmpty())
                                    <span class="skill-project-count">
                                        {{ $skill->projects->count() }} {{ $skill->projects->count() > 1 ? __('common.projects_count_plural_unit') : __('common.projects_count_unit') }}
                                    </span>
                                @endif
                            </div>
                            @if ($skill->description)
                                <p class="skill-entry-description">{{ $skill->description }}</p>
                            @endif

                            @if ($skill->projects->isNotEmpty())
                                <div class="skill-entry-projects">
                                    <p>{{ __('skills.applied_in') }}</p>
                                    <div>
                                        @foreach ($skill->projects->take(3) as $project)
                                            <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate>
                                                {{ $project->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    @if ($this->byRole->isEmpty())
        <div class="skills-empty">
            {{ __('skills.empty') }}
        </div>
    @endif

</div>
