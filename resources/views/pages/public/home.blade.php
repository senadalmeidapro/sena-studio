<div class="public-page home-page space-y-20 pb-20 sm:space-y-28">

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid [mask-image:radial-gradient(ellipse_at_top,black_30%,transparent_72%)]" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 pt-16 sm:px-6 lg:grid-cols-[1.08fr_0.92fr] lg:gap-24 lg:px-8 lg:pt-28">
            {{-- Colonne texte --}}
            <div class="motion-safe:animate-fade-up">
                <div class="flex items-center gap-3">
                    <span class="eyebrow">{{ __('home.hero_eyebrow') }}</span>
                </div>

                <h1 class="mt-7 max-w-3xl font-display text-5xl font-bold leading-[1.02] tracking-[-0.045em] text-text  sm:text-6xl lg:text-[4.25rem]">
                    {{ __('home.tagline') }}
                </h1>

                <p class="mt-7 max-w-xl text-pretty text-lg leading-relaxed text-text-muted ">
                    {{ __('home.intro') }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-2">
                    @foreach (['Backend', 'APIs', 'Architecture', 'DevOps'] as $tech)
                        <span class="rounded-md border border-border bg-surface/60 px-3 py-1.5 font-mono text-[0.68rem] uppercase tracking-[0.12em] text-text-muted   ">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-6">
                    <a href="{{ localized_route('projects.index') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-accent px-6 py-3.5 font-display text-base font-medium text-on-accent shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent-hover hover:shadow-lifted   ">
                        {{ __('home.cta_projects') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <x-front.arrow-link :href="localized_route('contact')" wire:navigate>
                        {{ __('home.cta_discuss') }}
                    </x-front.arrow-link>
                </div>

                <dl class="mt-14 grid max-w-xl grid-cols-2 gap-8 border-t border-border pt-6 ">
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-text-muted ">{{ __('home.stats_projects') }}</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-text ">{{ $this->projectCount }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-text-muted ">{{ __('home.stats_case_studies') }}</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-text ">{{ $this->caseStudyCount }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-text-muted ">{{ __('home.stats_base') }}</dt>
                        <dd class="mt-1.5 font-display text-2xl font-semibold tracking-tight text-text ">{{ __('home.stats_location') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Colonne architecture --}}
            <div class="relative mx-auto w-full max-w-sm motion-safe:animate-fade-up [animation-delay:160ms] lg:max-w-none">
                <div class="technical-visual p-5 sm:p-7">
                    <div class="mb-6 flex items-center justify-between font-mono text-[0.62rem] uppercase tracking-[0.16em] text-text-muted">
                        <span>system.map</span>
                        <span>v1.0 / online</span>
                    </div>
                    <div class="grid gap-3">
                        <div class="technical-node px-4 py-3">{{ __('home.diagram_interface') }}</div>
                        <div class="mx-auto h-5 w-px bg-border"></div>
                        <div class="technical-node border-border bg-surface-muted px-4 py-3 text-center">{{ __('home.diagram_api') }}</div>
                        <div class="mx-auto h-5 w-px bg-border"></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="technical-node px-3 py-3 text-center">{{ __('home.diagram_database') }}</div>
                            <div class="technical-node px-3 py-3 text-center">{{ __('home.diagram_jobs') }}</div>
                        </div>
                    </div>
                    <div class="mt-7 flex items-center gap-2 font-mono text-[0.62rem] uppercase tracking-[0.14em] text-text-muted">
                        <span class="size-1.5 rounded-full bg-border"></span>
                        {{ __('home.diagram_caption') }}
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between gap-4">
                    <span class="flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.16em] text-text-muted ">
                        <span class="size-1.5 rounded-full bg-accent"></span>
                        {{ __('availability.'.$availability) }}
                    </span>
                </div>

                <div class="engineering-panel mt-6 px-5 py-4">
                    <div class="flex items-center gap-2 text-sm font-medium text-text ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-text-muted">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {!! __('home.badge') !!}
                    </div>
                    <div class="mt-1 pl-6 font-mono text-[0.68rem] uppercase tracking-[0.14em] text-text-muted ">{{ __('home.badge_sub') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            :label="__('home.services.label')"
            :title="__('home.services.title')"
            :subtitle="__('home.services.subtitle')"
        />

        <ol class="divide-y divide-border border-y border-border  ">
            @foreach ([
                [[__('home.services.web'), __('home.services.web_text')], 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5'],
                [[__('home.services.saas'), __('home.services.saas_text')], 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
                [[__('home.services.apis'), __('home.services.apis_text')], 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99'],
                [[__('home.services.perf'), __('home.services.perf_text')], 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941'],
            ] as [[$title, $text], $icon])
                <li class="group grid gap-2 py-8 transition-colors hover:bg-surface-muted sm:grid-cols-[3.5rem_1fr] sm:items-start sm:gap-6 sm:px-4 sm:py-10 ">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-surface-muted text-text transition-colors group-hover:bg-surface group-hover:text-text    ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </span>
                    <div class="grid gap-1 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-baseline sm:gap-8">
                        <div>
                            <h3 class="font-display text-xl font-medium tracking-tight text-text ">{{ $title }}</h3>
                            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-text-muted ">{{ $text }}</p>
                        </div>
                        <span class="hidden max-w-xs justify-end pt-1 font-medium text-text-muted opacity-0 transition-all duration-300 group-hover:opacity-100 sm:flex ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5 -rotate-45 transition-transform duration-300 group-hover:rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </span>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            :label="__('home.method.label')"
            :title="__('home.method.title')"
            :subtitle="__('home.method.subtitle')"
            align="center"
        />

        <ol class="grid gap-px overflow-hidden rounded-2xl border border-border bg-border sm:grid-cols-2 lg:grid-cols-4  ">
            @foreach ([
                [__('home.method.step1'), __('home.method.step1_text')],
                [__('home.method.step2'), __('home.method.step2_text')],
                [__('home.method.step3'), __('home.method.step3_text')],
                [__('home.method.step4'), __('home.method.step4_text')],
            ] as [$title, $text])
                <li class="group flex flex-col gap-3 bg-surface p-7 shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-surface-muted hover:shadow-card sm:p-8 ">
                    <h3 class="font-display text-lg font-medium tracking-tight text-text ">{{ $title }}</h3>
                    <p class="text-sm leading-relaxed text-text-muted ">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            :label="__('home.engagement.label')"
            :title="__('home.engagement.title')"
            :subtitle="__('home.engagement.subtitle')"
        />

        <div class="grid gap-4 md:grid-cols-3">
            @foreach ([
                [__('home.engagement.mvp'), __('home.engagement.mvp_text')],
                [__('home.engagement.audit'), __('home.engagement.audit_text')],
                [__('home.engagement.continuous'), __('home.engagement.continuous_text')],
            ] as [$title, $text])
                <article class="rounded-2xl border border-border bg-surface p-6 transition-colors hover:border-border  ">
                    <h3 class="font-display text-xl font-semibold tracking-tight text-text ">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-text-muted ">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </section>

    @if ($this->featuredProjects->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-front.section-heading
                :label="__('home.portfolio.label')"
                :title="__('home.portfolio.title')"
                :subtitle="__('home.portfolio.subtitle')"
                :actionHref="localized_route('projects.index')"
                :actionLabel="__('common.see_all')"
            />

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($this->featuredProjects as $project)
                    <a href="{{ localized_route('projects.show', $project->slug) }}" wire:navigate
                       class="group flex flex-col overflow-hidden rounded-xl border border-border bg-surface transition-all duration-300 hover:-translate-y-1 hover:border-border hover:shadow-card  ">
                        <x-project-media :image="$project->image" :label="$project->name" />
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-4 flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
                                <span class="rounded-md bg-surface-muted px-2 py-1 text-text-muted  ">{{ $project->type->label() }}</span>
                                @php
                                    $statusTone = match ($project->status) {
                                        \App\Enums\ProjectStatus::Production => ['bg-surface-muted text-success  '],
                                        \App\Enums\ProjectStatus::Testing => ['bg-surface-muted text-warning  '],
                                        \App\Enums\ProjectStatus::Development => ['bg-accent-soft text-accent  '],
                                        \App\Enums\ProjectStatus::Cancelled => ['bg-surface-muted text-text-muted  '],
                                    };
                                @endphp
                                <span class="rounded-md px-2 py-1 {{ $statusTone[0] }}">{{ $project->status->label() }}</span>
                            </div>
                            <h3 class="font-display text-xl font-medium tracking-tight text-text transition-colors group-hover:text-accent  ">
                                {{ $project->name }}
                            </h3>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-text-muted ">
                                {{ $project->description }}
                            </p>
                            @if ($project->problem || $project->result)
                                <div class="mt-4 space-y-2 border-l-2 border-border pl-3 text-sm leading-relaxed text-text-muted ">
                                    @if ($project->problem)
                                        <p><span class="font-semibold text-text ">{{ __('project.case_study_problem') }}:</span> {{ str($project->problem)->limit(125) }}</p>
                                    @endif
                                    @if ($project->result)
                                        <p><span class="font-semibold text-text ">{{ __('project.case_study_result') }}:</span> {{ str($project->result)->limit(125) }}</p>
                                    @endif
                                </div>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-1.5 font-mono text-[0.68rem] uppercase tracking-[0.08em]">
                                @foreach ($project->skills->take(3) as $skill)
                                    <span class="rounded bg-surface-muted px-2 py-0.5 text-text-muted  ">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            @if ($project->url)
                                <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-accent transition-colors group-hover:text-accent  ">
                                    {{ __('home.cta_projects') }}
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

    @if ($this->topSkills->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-front.section-heading
                :label="__('home.expertise.label')"
                :title="__('home.expertise.title')"
                :subtitle="__('home.expertise.subtitle')"
                :actionHref="localized_route('skills.index')"
                :actionLabel="__('home.expertise.action')"
            />

            <ul class="divide-y divide-border border-y border-border  ">
                @foreach ($this->topSkills as $skill)
                    <li>
                        <a href="{{ skill_url($skill->name) }}"
                           class="group flex items-center justify-between gap-4 py-4 transition-colors hover:bg-surface-muted ">
                            <span class="flex items-center gap-3.5">
                                @if ($skill->icon)
                                    <x-site-icon :icon="$skill->icon" class="size-5 text-text-muted transition-colors group-hover:text-text-muted " />
                                @endif
                                <span class="font-display text-lg font-medium tracking-tight text-text transition-colors group-hover:text-accent  ">{{ $skill->name }}</span>
                            </span>
                            <span class="hidden font-mono text-[0.68rem] uppercase tracking-[0.16em] text-text-muted sm:block">{{ $skill->category }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    @if ($this->stackHighlights->isNotEmpty())
        <section class="border-y border-border bg-surface-muted  ">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <x-front.section-heading
                    :label="__('home.stack.label')"
                    :title="__('home.stack.title')"
                    :subtitle="__('home.stack.subtitle')"
                    align="center"
                />
            </div>

            <div class="relative overflow-hidden border-t border-border py-5 ">
                <div class="flex w-max animate-marquee items-center gap-10">
                    @foreach ([0, 1] as $copy)
                        <div class="flex items-center gap-10" aria-hidden="{{ $copy === 1 ? 'true' : 'false' }}">
                            @foreach ($this->stackHighlights as $category => $items)
                                @foreach ($items as $item)
                                    <span class="flex items-center gap-10 font-display text-2xl tracking-tight text-text ">
                                        {{ $item->name }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-text-muted">
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
                            <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-text-muted">{{ __('skills.role_'.$category) }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($items->take(3) as $item)
                                    <a href="{{ skill_url($item->name) }}" class="inline-flex items-center gap-1.5 rounded-md bg-surface px-2.5 py-1 font-mono text-[0.7rem] uppercase tracking-[0.08em] text-text shadow-soft transition-colors hover:text-accent  ">
                                        @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                        {{ $item->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-front.arrow-link :href="localized_route('skills.index')" wire:navigate class="shrink-0">
                    {{ __('home.stack.explore') }}
                </x-front.arrow-link>
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-accent px-8 py-14 text-center shadow-lifted sm:px-14 sm:py-20">
            <div class="pointer-events-none absolute inset-0 bg-grid opacity-40 [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_70%)] dark:opacity-25" aria-hidden="true"></div>

            <div class="relative">
                <span class="font-mono text-[0.7rem] uppercase tracking-[0.25em] text-on-accent/80">{{ __('home.cta_banner.eyebrow') }}</span>
                <h2 class="mx-auto mt-4 max-w-2xl font-display text-3xl font-medium tracking-tight text-on-accent sm:text-5xl">
                    {!! __('home.cta_banner.title') !!}
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-pretty text-on-accent">
                    {{ __('home.cta_banner.text') }}
                </p>
                <div class="mt-9 flex flex-wrap items-center justify-center gap-6">
                    <a href="{{ localized_route('contact') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-surface px-6 py-3.5 font-display text-base font-medium text-accent shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent-soft hover:shadow-card  ">
                        {{ __('home.cta_banner.action') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ localized_route('skills.index') }}" wire:navigate class="font-medium text-accent underline-offset-4 transition-colors hover:text-on-accent hover:underline">
                        {{ __('home.cta_banner.secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
