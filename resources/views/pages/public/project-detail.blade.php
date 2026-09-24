<div class="public-page project-detail-page mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    <a href="{{ localized_route('projects.index') }}" wire:navigate class="group inline-flex items-center gap-1.5 font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 transition-colors hover:text-blue-600 dark:text-ink-400 dark:hover:text-blue-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:-translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        {{ __('common.back_projects') }}
    </a>

    {{-- Titre du projet (première position) --}}
    <header class="mt-10 max-w-3xl motion-safe:animate-fade-up">
        <h1 class="font-display text-4xl font-bold tracking-[-0.04em] text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ $project->name }}
        </h1>
    </header>

    {{-- Galerie --}}
    <div class="mt-8 motion-safe:animate-fade-up [animation-delay:80ms]">
        @php
            $galleryUrls = collect([$project->image])
                ->merge($project->projectImages->pluck('path'))
                ->filter()
                ->map(fn (string $path) => media_url($path))
                ->values();
        @endphp

        @if ($galleryUrls->isNotEmpty())
            <div x-data="{ active: 0, open: false, images: @js($galleryUrls->all()), count: @js($galleryUrls->count()), opener: null, openGallery() { this.opener = document.activeElement; this.open = true; this.$nextTick(() => this.$refs.closeButton.focus()); }, closeGallery() { this.open = false; this.$nextTick(() => this.opener?.focus()); }, trapFocus(event) { const items = [...this.$refs.dialog.querySelectorAll('button:not([disabled])')].filter((item) => item.offsetParent !== null); const first = items[0]; const last = items[items.length - 1]; if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); } else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); } } }"
                 x-on:keydown.escape.window="if (open) closeGallery()"
                 @class(['overflow-hidden rounded-3xl' => $galleryUrls->count() > 1])>
                <button
                    type="button"
                    @click="openGallery()"
                    class="crop-frame group block w-full overflow-hidden rounded-3xl border border-ink-300 bg-ink-100 text-left focus:outline-none dark:border-ink-700 dark:bg-ink-900"
                    aria-label="{{ __('common.fullscreen_gallery') }}"
                >
                    <div class="relative aspect-video">
                        <template x-for="(img, i) in images" :key="i">
                            <img
                                :src="img"
                                :class="i === active ? 'opacity-100' : 'pointer-events-none absolute inset-0 opacity-0'"
                                class="size-full object-cover transition-opacity duration-500"
                                :alt="@js($project->name . ' — ' . __('common.view')) + ' ' + (i + 1)"
                                :loading="i === active ? 'eager' : 'lazy'"
                                x-cloak
                            />
                        </template>
                        <span class="absolute inset-0 flex items-center justify-center bg-ink-950/0 opacity-0 transition-all duration-300 group-hover:bg-ink-950/45 group-hover:opacity-100">
                            <span class="inline-flex items-center gap-2 rounded-xl bg-white/90 px-4 py-2 font-mono text-[0.72rem] uppercase tracking-[0.14em] text-ink-900 backdrop-blur-sm dark:bg-ink-900/90 dark:text-ink-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15m11.25-11.25v4.5m0-4.5h-4.5m4.5 0L15 9m6 11.25v-4.5m0 4.5h-4.5m4.5 0L15 15" />
                                </svg>
                                {{ __('common.expand') }}
                            </span>
                        </span>
                    </div>
                </button>

                @if ($galleryUrls->count() > 1)
                    <div class="mt-3 flex gap-3">
                        <template x-for="(img, i) in images" :key="i">
                            <button
                                type="button"
                                @click="active = i"
                                :class="i === active ? 'ring-2 ring-blue-400 ring-offset-2 ring-offset-white dark:ring-offset-ink-950' : 'opacity-60 hover:opacity-100'"
                                class="w-24 overflow-hidden rounded-xl border border-ink-300 bg-ink-100 transition-all dark:border-ink-700 dark:bg-ink-800"
                                :aria-label="@js($project->name . ' — ' . __('common.preview')) + ' ' + (i + 1)"
                            >
                                <img :src="img" alt="" loading="lazy" class="aspect-video w-full object-cover" />
                            </button>
                        </template>
                    </div>
                @endif

                {{-- Lightbox --}}
                <template x-teleport="body">
                    <div
                        x-show="open"
                        x-cloak
                        x-transition.opacity.duration.200ms
                        @keydown.arrow-left.window="if (open) { $event.preventDefault(); active = (active - 1 + count) % count }"
                        @keydown.arrow-right.window="if (open) { $event.preventDefault(); active = (active + 1) % count }"
                        @keydown.tab="trapFocus($event)"
                        class="fixed inset-0 z-[100] flex flex-col bg-ink-950/95 p-4 backdrop-blur-sm sm:p-8"
                        x-ref="dialog"
                        tabindex="-1"
                        role="dialog"
                        aria-modal="true"
                        aria-label="{{ __('common.fullscreen_gallery') }}"
                    >
                        <div class="mx-auto flex w-full max-w-6xl items-center justify-end">
                            <button
                                type="button"
                                x-ref="closeButton"
                                @click="closeGallery()"
                                class="inline-flex size-10 items-center justify-center rounded-full border border-ink-700 text-ink-100 transition-colors hover:border-ink-500 hover:bg-ink-800"
                                aria-label="{{ __('common.close') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="relative mx-auto mt-4 flex w-full max-w-6xl flex-1 items-center justify-center">
                            <button
                                type="button"
                                @click="active = (active - 1 + count) % count"
                                x-show="count > 1"
                                class="absolute left-0 z-10 inline-flex size-12 items-center justify-center rounded-full border border-ink-700 bg-ink-900/60 text-ink-100 transition-colors hover:bg-ink-800 sm:-left-4"
                                aria-label="{{ __('common.previous') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                            </button>

                            <img
                                :src="images[active]"
                                :alt="@js($project->name . ' — ' . __('common.view')) + ' ' + (active + 1)"
                                x-transition.opacity.duration.200ms
                                class="max-h-[78vh] w-auto rounded-xl object-contain shadow-2xl"
                            />

                            <button
                                type="button"
                                @click="active = (active + 1) % count"
                                x-show="count > 1"
                                class="absolute right-0 z-10 inline-flex size-12 items-center justify-center rounded-full border border-ink-700 bg-ink-900/60 text-ink-100 transition-colors hover:bg-ink-800 sm:-right-4"
                                aria-label="{{ __('common.next') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        <div class="mx-auto mt-4 flex w-full max-w-6xl items-center justify-center gap-3">
                            <template x-for="(img, i) in images" :key="i">
                                <button
                                    type="button"
                                    @click="active = i"
                                    :aria-pressed="i === active"
                                    :class="i === active ? 'ring-2 ring-blue-400' : 'opacity-50 hover:opacity-100'"
                                    class="w-16 overflow-hidden rounded-lg border border-ink-700 transition-all"
                                    :aria-label="@js($project->name . ' — ' . __('common.preview')) + ' ' + (i + 1)"
                                >
                                    <img :src="img" alt="" loading="lazy" class="aspect-video w-full object-cover" />
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        @else
            <x-project-media :image="$project->image" :label="$project->name" />
        @endif
    </div>

    {{-- En-tête --}}
    <header class="mt-12 grid gap-8 border-b border-ink-300 pb-12 motion-safe:animate-fade-up [animation-delay:160ms] lg:grid-cols-[1fr_auto] lg:items-end dark:border-ink-700">
        <div>
            <div class="flex flex-wrap items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
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
                <span class="rounded-md bg-ink-100 px-2 py-1 text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $project->complexity->label() }}</span>
            </div>

            @if ($project->description)
                <p class="mt-5 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                    {{ $project->description }}
                </p>
            @endif
            @if ($project->role || $project->started_at || $project->ended_at || $project->categories->isNotEmpty())
                <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-4 border-t border-ink-200 pt-5 dark:border-ink-700">
                    @if ($project->role)
                        <div class="max-w-sm">
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('project.contribution') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-ink-800 dark:text-ink-100">{{ $project->role }}</dd>
                        </div>
                    @endif
                    @if ($project->started_at || $project->ended_at)
                        <div>
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('project.timeline') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-ink-800 dark:text-ink-100">{{ $project->started_at?->translatedFormat('M Y') ?? '—' }} – {{ $project->ended_at?->translatedFormat('M Y') ?? __('project.ongoing') }}</dd>
                        </div>
                    @endif
                    @if ($project->categories->isNotEmpty())
                        <div>
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-ink-500 dark:text-ink-400">{{ __('project.domain') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-ink-800 dark:text-ink-100">{{ $project->categories->pluck('name')->join(' · ') }}</dd>
                        </div>
                    @endif
                </dl>
            @endif
        </div>

        @if ($project->url || $project->repository_url)
            <div class="flex shrink-0 flex-wrap gap-3 lg:justify-end">
                @if ($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-blue-600 px-6 py-3 font-display text-base font-medium text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-card dark:bg-blue-500 dark:text-blue-950 dark:hover:bg-blue-400">
                        {{ __('project.visit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif
                @if ($project->repository_url)
                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-lg border border-ink-300 bg-card px-6 py-3 font-display text-base font-medium text-ink-700 shadow-soft transition-all duration-200 hover:-translate-y-0.5 hover:border-ink-400 hover:bg-ink-50 hover:shadow-card dark:border-ink-700 dark:text-ink-200 dark:hover:border-ink-500 dark:hover:bg-ink-800">
                        {{ __('project.source') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </header>

    {{-- Compétences mobilisées --}}
    @if ($project->problem || $project->architecture || $project->technical_decisions || $project->result)
        <section class="mt-14 border-y border-ink-300 py-12 dark:border-ink-700" aria-labelledby="project-case-study-title">
            <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="eyebrow">{{ __('project.case_study_eyebrow') }}</p>
                    <h2 id="project-case-study-title" class="mt-3 max-w-md font-display text-3xl font-bold tracking-[-0.035em] text-ink-900 dark:text-ink-50">
                        {{ __('project.case_study_title') }}
                    </h2>
                </div>

                <div class="relative grid gap-x-8 gap-y-9 border-l border-ink-200 pl-6 dark:border-ink-700 sm:grid-cols-2">
                    @foreach ([
                        'problem' => 'project.case_study_problem',
                        'architecture' => 'project.case_study_architecture',
                        'technical_decisions' => 'project.case_study_decisions',
                        'result' => 'project.case_study_result',
                    ] as $field => $label)
                        @if ($project->{$field})
                            <article class="relative">
                                <span aria-hidden="true" class="absolute -left-[1.72rem] top-1.5 size-2 rounded-full bg-blue-500 ring-4 ring-canvas"></span>
                                <h3 class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                    {{ __($label) }}
                                </h3>
                                <p class="mt-3 text-sm leading-7 text-ink-600 dark:text-ink-300">
                                    {{ $project->{$field} }}
                                </p>
                            </article>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($project->skills->isNotEmpty())
        <section class="mt-12">
            <div>
                <h2 class="eyebrow">{{ __('project.skills_title') }}</h2>
            </div>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <a href="{{ skill_url($skill->name) }}" class="inline-flex items-center gap-2 rounded-lg border border-ink-300 bg-card px-3 py-1.5 font-mono text-[0.72rem] uppercase tracking-[0.08em] text-ink-700 shadow-soft transition-colors hover:border-blue-400 hover:text-blue-700 dark:border-ink-700 dark:text-ink-200 dark:hover:border-blue-500 dark:hover:text-blue-300">
                        @if ($skill->icon) <x-site-icon :icon="$skill->icon" class="size-4" /> @endif
                        {{ $skill->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Stack du projet --}}
    @if ($project->stack && $project->stack->stackItems->isNotEmpty())
        <section class="mt-14">
            <div class="flex flex-wrap items-baseline justify-between gap-3">
                <div>
                    <h2 class="eyebrow">{{ __('project.stack_title') }}</h2>
                </div>
                <p class="font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ $project->stack->name }}</p>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                @foreach ($project->stack->stackItems->groupBy('category') as $category => $items)
                    <div class="rounded-2xl border border-ink-300 bg-card p-6 shadow-soft dark:border-ink-700">
                        <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-blue-600 dark:text-blue-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($items as $item)
                                @if ($project->skills->contains('name', $item->value))
                                    <a href="{{ skill_url($item->value) }}" class="inline-flex items-center gap-1.5 rounded bg-ink-100 px-2 py-1 font-mono text-[0.72rem] text-ink-700 transition-colors hover:text-blue-700 dark:bg-ink-800 dark:text-ink-200 dark:hover:text-blue-300">
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded bg-ink-100 px-2 py-1 font-mono text-[0.72rem] text-ink-700 dark:bg-ink-800 dark:text-ink-200">
                                @endif
                                    @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                    {{ $item->value }}@if ($item->version) <span class="text-ink-500 dark:text-ink-500">{{ $item->version }}</span>@endif
                                @if ($project->skills->contains('name', $item->value))</a>@else</span>@endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Infrastructure --}}
    @if ($project->infra)
        <section class="mt-14">
            <div>
                <h2 class="eyebrow">{{ __('project.infra_title') }}</h2>
            </div>
            <dl class="mt-6 grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300/80 sm:grid-cols-3 dark:border-ink-700 dark:bg-ink-700/60">
                <div class="group bg-card p-6 shadow-soft transition-colors hover:bg-blue-50/50 dark:hover:bg-blue-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ __('project.environment') }}</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ $project->infra->environment->label() }}</dd>
                </div>
                <div class="bg-card p-6 shadow-soft transition-colors hover:bg-blue-50/50 dark:hover:bg-blue-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">CPU / RAM</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ __('project.cores', ['count' => $project->infra->cpu_cores, 'memory' => $project->infra->memory_mb]) }}</dd>
                </div>
                <div class="bg-card p-6 shadow-soft transition-colors hover:bg-blue-50/50 dark:hover:bg-blue-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ __('project.storage') }}</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ $project->infra->storage_gb }} Go</dd>
                </div>
            </dl>
        </section>
    @endif

    {{-- CTA suivant --}}
    <div class="mt-20 flex flex-wrap items-center justify-between gap-6 rounded-2xl border border-ink-300 bg-blue-50/50 px-8 py-7 shadow-soft dark:border-ink-700 dark:bg-blue-950/20">
        <p class="font-display text-xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
            {!! __('project.inspired') !!}
        </p>
        <x-front.arrow-link :href="localized_route('contact')" wire:navigate>
            {{ __('common.talk_about_yours') }}
        </x-front.arrow-link>
    </div>
</div>
