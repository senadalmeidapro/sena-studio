<div class="space-y-24 pb-24 sm:space-y-32">

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid [mask-image:radial-gradient(ellipse_at_top,black_30%,transparent_72%)]" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 pt-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20 lg:px-8 lg:pt-28">
            {{-- Colonne texte --}}
            <div class="motion-safe:animate-fade-up">
                <div class="flex items-center gap-3">
                    <span class="eyebrow">{{ __('home.hero_eyebrow') }}</span>
                </div>

                <h1 class="mt-7 font-display text-5xl font-medium leading-[1.02] tracking-tight text-ink-900 dark:text-ink-50 sm:text-6xl lg:text-7xl">
                    Sena Studio
                    <span class="mt-1 block text-blue-600 dark:text-blue-400">
                        {{ __('home.tagline') }}
                    </span>
                </h1>

                <p class="mt-7 max-w-xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                    {{ __('home.intro') }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-2">
                    @foreach (['Laravel', 'Livewire', 'Filament', 'Tailwind'] as $tech)
                        <span class="rounded-full border border-ink-300 px-3 py-1 font-mono text-[0.7rem] uppercase tracking-[0.12em] text-ink-600 dark:border-ink-700 dark:text-ink-300">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-6">
                    <a href="{{ localized_route('projects.index') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-blue-600 px-6 py-3.5 font-display text-base font-medium text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-lifted dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">
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

                <dl class="mt-14 grid max-w-xl grid-cols-3 gap-8 border-t border-ink-300 pt-6 dark:border-ink-700">
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ __('home.stats_projects') }}</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">{{ $this->projectCount }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ __('home.stats_expertise') }}</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">{{ $this->topSkills->count() }}+</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ __('home.stats_custom') }}</dt>
                        <dd class="mt-1.5 font-display text-3xl font-medium tabular-nums text-ink-900 dark:text-ink-50">100%</dd>
                    </div>
                </dl>
            </div>

            {{-- Colonne photo --}}
            <div class="relative mx-auto w-full max-w-sm motion-safe:animate-fade-up [animation-delay:160ms] lg:max-w-none">
                <div class="crop-frame">
                    <div class="relative rotate-2 rounded-[2rem] bg-blue-500 p-1.5 transition-transform duration-500 hover:rotate-0">
                        <img
                            src="{{ asset('images/portrait.jpeg') }}"
                            alt="Portrait Sena Studio"
                            class="aspect-square w-full rounded-[1.6rem] bg-card object-cover"
                        />
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between gap-4">
                    <span class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-400 dark:text-ink-500">{{ __('home.fig_portrait') }}</span>
                    <span class="flex items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.16em] text-emerald-600 dark:text-emerald-400">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                        </span>
                        {{ __('home.available') }}
                    </span>
                </div>

                <div class="mt-6 rounded-2xl border border-ink-300 bg-card px-5 py-4 shadow-soft dark:border-ink-700">
                    <div class="flex items-center gap-2 text-sm font-medium text-ink-800 dark:text-ink-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-blue-600 dark:text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {!! __('home.badge') !!}
                    </div>
                    <div class="mt-1 pl-6 font-mono text-[0.68rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('home.badge_sub') }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== 01 — SERVICES ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            :label="__('home.services.label')"
            :title="__('home.services.title')"
            :subtitle="__('home.services.subtitle')"
        />

        <ol class="divide-y divide-ink-300 border-y border-ink-300 dark:divide-ink-700 dark:border-ink-700">
            @foreach ([
                [[__('home.services.web'), __('home.services.web_text')], 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5'],
                [[__('home.services.saas'), __('home.services.saas_text')], 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
                [[__('home.services.apis'), __('home.services.apis_text')], 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99'],
                [[__('home.services.perf'), __('home.services.perf_text')], 'M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941'],
            ] as $i => [[$title, $text], $icon])
                <li class="group grid gap-2 py-8 transition-colors hover:bg-blue-50/50 sm:grid-cols-[3.5rem_3.5rem_1fr] sm:items-start sm:gap-6 sm:px-4 sm:py-10 dark:hover:bg-blue-950/20">
                    <span class="pt-1 font-mono text-xs tabular-nums text-ink-400 transition-colors group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="flex size-11 items-center justify-center rounded-xl bg-ink-100 text-ink-700 transition-colors group-hover:bg-blue-500 group-hover:text-white dark:bg-ink-800 dark:text-ink-200 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </span>
                    <div class="grid gap-1 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-baseline sm:gap-8">
                        <div>
                            <h3 class="font-display text-xl font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                            <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                        </div>
                        <span class="hidden max-w-xs justify-end pt-1 font-medium text-blue-600 opacity-0 transition-all duration-300 group-hover:opacity-100 sm:flex dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5 -rotate-45 transition-transform duration-300 group-hover:rotate-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </span>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== 02 — MÉTHODE ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-front.section-heading
            :label="__('home.method.label')"
            :title="__('home.method.title')"
            :subtitle="__('home.method.subtitle')"
            align="center"
        />

        <ol class="grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300/80 sm:grid-cols-2 lg:grid-cols-4 dark:border-ink-700 dark:bg-ink-700/60">
            @foreach ([
                [__('home.method.step1'), __('home.method.step1_text')],
                [__('home.method.step2'), __('home.method.step2_text')],
                [__('home.method.step3'), __('home.method.step3_text')],
                [__('home.method.step4'), __('home.method.step4_text')],
            ] as $i => [$title, $text])
                <li class="group flex flex-col gap-3 bg-card p-7 shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-50/60 hover:shadow-card sm:p-8 dark:hover:bg-blue-950/20">
                    <span class="font-display text-4xl font-medium text-blue-600/80 transition-colors group-hover:text-blue-600 dark:text-blue-400/80 dark:group-hover:text-blue-400">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <h3 class="font-display text-lg font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $title }}</h3>
                    <p class="text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== 03 — PORTFOLIO ===================== --}}
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
                       class="group flex flex-col overflow-hidden rounded-2xl border border-ink-300 bg-card shadow-soft transition-all duration-300 hover:-translate-y-1 hover:border-blue-400/60 hover:shadow-card dark:border-ink-700 dark:hover:border-blue-500/40">
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
                            <h3 class="font-display text-xl font-medium tracking-tight text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">
                                {{ $project->name }}
                            </h3>
                            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                                {{ $project->description }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-1.5 font-mono text-[0.68rem] uppercase tracking-[0.08em]">
                                @foreach ($project->skills->take(3) as $skill)
                                    <span class="rounded bg-ink-100/80 px-2 py-0.5 text-ink-600 dark:bg-ink-800/70 dark:text-ink-300">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            @if ($project->url)
                                <span class="mt-4 inline-flex items-center gap-1.5 font-medium text-blue-600 transition-colors group-hover:text-blue-700 dark:text-blue-300 dark:group-hover:text-blue-200">
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

    {{-- ===================== 04 — EXPERTISES ===================== --}}
    @if ($this->topSkills->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-front.section-heading
                :label="__('home.expertise.label')"
                :title="__('home.expertise.title')"
                :subtitle="__('home.expertise.subtitle')"
                :actionHref="localized_route('skills.index')"
                :actionLabel="__('home.expertise.action')"
            />

            <ul class="divide-y divide-ink-300 border-y border-ink-300 dark:divide-ink-700 dark:border-ink-700">
                @foreach ($this->topSkills as $skill)
                    <li>
                        <a href="{{ localized_route('skills.index') }}" wire:navigate
                           class="group flex items-center justify-between gap-4 py-4 transition-colors hover:bg-blue-50/50 dark:hover:bg-blue-950/20">
                            <span class="flex items-center gap-3.5">
                                @if ($skill->icon)
                                    <x-site-icon :icon="$skill->icon" class="size-5 text-ink-400 transition-colors group-hover:text-blue-600 dark:text-ink-500 dark:group-hover:text-blue-400" />
                                @endif
                                <span class="font-display text-lg font-medium tracking-tight text-ink-900 transition-colors group-hover:text-blue-700 dark:text-ink-50 dark:group-hover:text-blue-300">{{ $skill->name }}</span>
                            </span>
                            <span class="hidden font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 sm:block dark:text-ink-500">{{ $skill->level->label() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- ===================== 05 — STACK (bande marquee) ===================== --}}
    @if ($this->stackHighlights->isNotEmpty())
        <section class="border-y border-ink-300 bg-blue-50/60 dark:border-ink-700 dark:bg-surface">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <x-front.section-heading
                    :label="__('home.stack.label')"
                    :title="__('home.stack.title')"
                    :subtitle="__('home.stack.subtitle')"
                    align="center"
                />
            </div>

            <div class="relative overflow-hidden border-t border-ink-300 py-5 dark:border-ink-700">
                <div class="flex w-max animate-marquee items-center gap-10">
                    @foreach ([0, 1] as $copy)
                        <div class="flex items-center gap-10" aria-hidden="{{ $copy === 1 ? 'true' : 'false' }}">
                            @foreach ($this->stackHighlights as $category => $items)
                                @foreach ($items as $item)
                                    <span class="flex items-center gap-10 font-display text-2xl tracking-tight text-ink-800 dark:text-ink-100">
                                        {{ $item->value }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-blue-500">
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
                            <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-blue-600 dark:text-blue-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($items->take(3) as $item)
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-card px-2.5 py-1 font-mono text-[0.7rem] uppercase tracking-[0.08em] text-ink-700 shadow-soft dark:text-ink-200">
                                        @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                        {{ $item->value }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-front.arrow-link :href="localized_route('stack.index')" wire:navigate class="shrink-0">
                    {{ __('home.stack.explore') }}
                </x-front.arrow-link>
            </div>
        </section>
    @endif

    {{-- ===================== 06 — CTA ===================== --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-blue-600 px-8 py-14 text-center shadow-lifted sm:px-14 sm:py-20">
            <div class="pointer-events-none absolute inset-0 bg-grid opacity-40 [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_70%)] dark:opacity-25" aria-hidden="true"></div>

            <div class="relative">
                <span class="font-mono text-[0.7rem] uppercase tracking-[0.25em] text-blue-200">{{ __('home.cta_banner.eyebrow') }}</span>
                <h2 class="mx-auto mt-4 max-w-2xl font-display text-3xl font-medium tracking-tight text-white sm:text-5xl">
                    {!! __('home.cta_banner.title') !!}
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-pretty text-blue-100">
                    {{ __('home.cta_banner.text') }}
                </p>
                <div class="mt-9 flex flex-wrap items-center justify-center gap-6">
                    <a href="{{ localized_route('contact') }}" wire:navigate
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-white px-6 py-3.5 font-display text-base font-medium text-blue-700 shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-50 hover:shadow-card dark:text-blue-800 dark:hover:bg-blue-100">
                        {{ __('home.cta_banner.action') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             class="size-4 transition-transform duration-300 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ localized_route('stack.index') }}" wire:navigate class="font-medium text-blue-100 underline-offset-4 transition-colors hover:text-white hover:underline">
                        {{ __('home.cta_banner.secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>