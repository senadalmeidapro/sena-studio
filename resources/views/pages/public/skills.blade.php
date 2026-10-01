<div class="public-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-border pb-10 motion-safe:animate-fade-up ">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('skills.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-text  sm:text-5xl">
            {{ __('skills.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-text-muted ">
            {{ __('skills.subtitle') }}
        </p>
    </header>

    <section class="mt-10 grid gap-4 border-y border-border py-6  sm:grid-cols-[1.2fr_repeat(3,1fr)] sm:items-center">
        <div>
            <p class="eyebrow">{{ __('skills.signal_title') }}</p>
            <p class="mt-2 max-w-md text-sm leading-relaxed text-text-muted ">{{ __('skills.signal_text') }}</p>
        </div>
        @foreach ([__('skills.signal_backend'), __('skills.signal_data'), __('skills.signal_infra')] as $label)
            <div class="border-l border-border pl-4 ">
                <span class="block size-2 rounded-full bg-border"></span>
                <p class="mt-3 text-sm font-medium text-text ">{{ $label }}</p>
            </div>
        @endforeach
    </section>

    <div class="mt-12 space-y-16">
        @foreach ($this->byRole as $roleKey => $skills)
            <section>
                <div class="mb-6 flex items-baseline gap-4">
                    <h2 class="font-display text-2xl font-medium tracking-tight text-text ">
                        {{ __('skills.role_'.$roleKey) }}
                    </h2>
                    <span class="hidden font-mono text-[0.7rem] uppercase tracking-[0.14em] text-text-muted sm:block">
                        {{ $skills->count() }} {{ $skills->count() > 1 ? __('skills.count_plural_unit') : __('skills.count_unit') }}
                    </span>
                    <span aria-hidden="true" class="hidden h-px min-w-8 flex-1 bg-border sm:block "></span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills as $skill)
                        <div id="{{ skill_anchor($skill->name) }}" class="group scroll-mt-28 flex flex-col rounded-2xl border border-border bg-surface p-6 shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:border-border hover:shadow-card  ">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    @if ($skill->icon)
                                        <span class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-surface-muted text-text transition-colors group-hover:bg-surface group-hover:text-text    ">
                                            <x-site-icon :icon="$skill->icon" class="size-6" />
                                        </span>
                                    @endif
                                    <h3 class="font-display text-lg font-medium tracking-tight text-text ">{{ $skill->name }}</h3>
                                </div>
                                @if ($skill->projects->isNotEmpty())
                                    <span class="shrink-0 font-mono text-[0.68rem] uppercase tracking-[0.1em] text-text-muted ">
                                        {{ $skill->projects->count() }} {{ $skill->projects->count() > 1 ? __('common.projects_count_plural_unit') : __('common.projects_count_unit') }}
                                    </span>
                                @endif
                            </div>
                            @if ($skill->description)
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-text-muted ">{{ $skill->description }}</p>
                            @endif

                            @if ($skill->projects->isNotEmpty())
                                <p class="mt-5 font-mono text-[0.64rem] uppercase tracking-[0.12em] text-text-muted ">{{ __('skills.applied_in') }}</p>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach ($skill->projects->take(3) as $project)
                                    <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate
                                       class="rounded bg-surface-muted px-2 py-0.5 font-mono text-[0.68rem] uppercase tracking-[0.08em] text-text-muted transition-colors hover:text-accent   ">
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

    @if ($this->byRole->isEmpty())
        <div class="mt-12 rounded-2xl border border-dashed border-border p-12 text-center text-text-muted  ">
            {{ __('skills.empty') }}
        </div>
    @endif

</div>
