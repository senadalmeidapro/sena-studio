<div class="public-page project-detail-page mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    <a href="{{ localized_route('projects.index') }}" wire:navigate class="group inline-flex items-center gap-1.5 font-mono text-[0.7rem] uppercase tracking-[0.16em] text-text-muted transition-colors hover:text-accent  ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:-translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        {{ __('common.back_projects') }}
    </a>

    {{-- Titre du projet (première position) --}}
    <header class="mt-10 max-w-3xl motion-safe:animate-fade-up">
        <h1 class="font-display text-4xl font-bold tracking-[-0.04em] text-text  sm:text-5xl">
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
                    class="crop-frame group block w-full overflow-hidden rounded-3xl border border-border bg-surface-muted text-left focus:outline-none  "
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
                        <span class="absolute inset-0 flex items-center justify-center bg-bg opacity-0 transition-all duration-300 group-hover:bg-surface-muted group-hover:opacity-100">
                            <span class="inline-flex items-center gap-2 rounded-xl bg-surface px-4 py-2 font-mono text-[0.72rem] uppercase tracking-[0.14em] text-text backdrop-blur-sm  ">
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
                                :class="i === active ? 'ring-2 ring-accent ring-offset-2 ring-offset-surface ' : 'opacity-60 hover:opacity-100'"
                                class="w-24 overflow-hidden rounded-xl border border-border bg-surface-muted transition-all  "
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
                        class="fixed inset-0 z-[100] flex flex-col bg-bg p-4 backdrop-blur-sm sm:p-8"
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
                                class="inline-flex size-10 items-center justify-center rounded-full border border-border text-text transition-colors hover:border-border hover:bg-surface-muted"
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
                                class="absolute left-0 z-10 inline-flex size-12 items-center justify-center rounded-full border border-border bg-surface text-text transition-colors hover:bg-surface-muted sm:-left-4"
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
                                class="absolute right-0 z-10 inline-flex size-12 items-center justify-center rounded-full border border-border bg-surface text-text transition-colors hover:bg-surface-muted sm:-right-4"
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
                                    :class="i === active ? 'ring-2 ring-accent' : 'opacity-50 hover:opacity-100'"
                                    class="w-16 overflow-hidden rounded-lg border border-border transition-all"
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
    <header class="mt-12 grid gap-8 border-b border-border pb-12 motion-safe:animate-fade-up [animation-delay:160ms] lg:grid-cols-[1fr_auto] lg:items-end ">
        <div>
            <div class="flex flex-wrap items-center gap-2 font-mono text-[0.68rem] uppercase tracking-[0.12em]">
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

            @if ($project->description)
                <p class="mt-5 max-w-2xl text-pretty text-lg leading-relaxed text-text-muted ">
                    {{ $project->description }}
                </p>
            @endif
            @if ($project->role || $project->started_at || $project->ended_at || $project->categories->isNotEmpty())
                <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-4 border-t border-border pt-5 ">
                    @if ($project->role)
                        <div class="max-w-sm">
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-text-muted ">{{ __('project.contribution') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-text ">{{ $project->role }}</dd>
                        </div>
                    @endif
                    @if ($project->started_at || $project->ended_at)
                        <div>
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-text-muted ">{{ __('project.timeline') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-text ">{{ $project->started_at?->translatedFormat('M Y') ?? '—' }} – {{ $project->ended_at?->translatedFormat('M Y') ?? __('project.ongoing') }}</dd>
                        </div>
                    @endif
                    @if ($project->categories->isNotEmpty())
                        <div>
                            <dt class="font-mono text-[0.64rem] uppercase tracking-[0.14em] text-text-muted ">{{ __('project.domain') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-text ">{{ $project->categories->pluck('name')->join(' · ') }}</dd>
                        </div>
                    @endif
                </dl>
            @endif
        </div>

        @if ($project->url || $project->repository_url)
            <div class="flex shrink-0 flex-wrap gap-3 lg:justify-end">
                @if ($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                       class="group inline-flex items-center gap-2.5 rounded-xl bg-accent px-6 py-3 font-display text-base font-medium text-on-accent shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-accent-hover hover:shadow-card   ">
                        {{ __('project.visit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif
                @if ($project->repository_url)
                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-lg border border-border bg-surface px-6 py-3 font-display text-base font-medium text-text shadow-soft transition-all duration-200 hover:-translate-y-0.5 hover:border-border hover:bg-surface-muted hover:shadow-card    ">
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
    @if ($project->result_metric || ($project->testimonial && $project->testimonial->is_visible))
        <section class="mt-10 grid gap-6 border-y border-border py-8  md:grid-cols-2">
            @if ($project->result_metric)
                <div>
                    <p class="eyebrow">{{ __('project.case_study_result') }}</p>
                    <p class="mt-3 font-display text-2xl font-semibold tracking-tight text-text-muted">{{ $project->result_metric }}</p>
                </div>
            @endif
            @if ($project->testimonial && $project->testimonial->is_visible)
                <blockquote class="border-l-2 border-border pl-5">
                    <p class="text-lg leading-relaxed text-text ">“{{ $project->testimonial->content }}”</p>
                    <footer class="mt-3 text-sm font-medium text-text-muted ">{{ $project->testimonial->name }}@if ($project->testimonial->role || $project->testimonial->company), {{ collect([$project->testimonial->role, $project->testimonial->company])->filter()->join(' · ') }}@endif</footer>
                </blockquote>
            @endif
        </section>
    @endif

    @if ($project->role || $project->client_context || $project->problem || $project->constraints || $project->architecture || $project->technical_decisions || $project->result || $project->outcome_type)
        <section class="mt-14 border-y border-border py-12 " aria-labelledby="project-case-study-title">
            <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="eyebrow">{{ __('project.case_study_eyebrow') }}</p>
                    <h2 id="project-case-study-title" class="mt-3 max-w-md font-display text-3xl font-bold tracking-[-0.035em] text-text ">
                        {{ __('project.case_study_title') }}
                    </h2>
                </div>

                <div class="relative grid gap-x-8 gap-y-9 border-l border-border pl-6  sm:grid-cols-2">
                    @foreach ([
                        'role' => 'project.case_study_role',
                        'problem' => 'project.case_study_context',
                        'client_context' => 'project.case_study_client_context',
                        'constraints' => 'project.case_study_constraints',
                        'architecture' => 'project.case_study_architecture',
                        'technical_decisions' => 'project.case_study_decisions',
                        'result' => 'project.case_study_result',
                    ] as $field => $label)
                        @if ($project->{$field})
                            <article class="relative">
                                <span aria-hidden="true" class="absolute -left-[1.72rem] top-1.5 size-2 rounded-full bg-border ring-4 ring-bg"></span>
                                <h3 class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-accent ">
                                    {{ __($label) }}
                                </h3>
                                <p class="mt-3 text-sm leading-7 text-text-muted ">
                                    {{ $project->{$field} }}
                                </p>
                            </article>
                        @endif
                    @endforeach

                    @if ($project->outcome_type)
                        <article class="relative">
                            <span aria-hidden="true" class="absolute -left-[1.72rem] top-1.5 size-2 rounded-full bg-border ring-4 ring-bg"></span>
                            <h3 class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-accent ">{{ __('project.case_study_outcome_type') }}</h3>
                            <p class="mt-3 text-sm leading-7 text-text-muted ">{{ __('project.outcome_'.$project->outcome_type->value) }}</p>
                        </article>
                    @endif
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
                    <a href="{{ skill_url($skill->name) }}" class="inline-flex items-center gap-2 rounded-lg border border-border bg-surface px-3 py-1.5 font-mono text-[0.72rem] uppercase tracking-[0.08em] text-text shadow-soft transition-colors hover:border-border hover:text-accent    ">
                        @if ($skill->icon) <x-site-icon :icon="$skill->icon" class="size-4" /> @endif
                        {{ $skill->name }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($project->deployment)
        <section class="mt-14">
            <h2 class="eyebrow">{{ __('project.infra_title') }}</h2>
            <p class="mt-4 max-w-3xl whitespace-pre-line text-sm leading-7 text-text-muted ">{{ $project->deployment }}</p>
        </section>
    @endif
    {{-- CTA suivant --}}
    <div class="mt-20 flex flex-wrap items-center justify-between gap-6 rounded-2xl border border-border bg-surface-muted px-8 py-7 shadow-soft  ">
        <p class="font-display text-xl font-medium tracking-tight text-text ">
            {!! __('project.inspired') !!}
        </p>
        <x-front.arrow-link :href="localized_route('contact')" wire:navigate>
            {{ __('common.talk_about_yours') }}
        </x-front.arrow-link>
    </div>
</div>
