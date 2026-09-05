<div class="mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    <a href="{{ route('projects.index') }}" wire:navigate class="group inline-flex items-center gap-1.5 font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 transition-colors hover:text-emerald-600 dark:text-ink-400 dark:hover:text-emerald-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 transition-transform duration-300 group-hover:-translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        Retour aux projets
    </a>

    {{-- Galerie --}}
    <div class="mt-8 motion-safe:animate-fade-up [animation-delay:80ms]">
        @php
            $galleryUrls = collect([$project->image])
                ->merge($project->projectImages->pluck('path'))
                ->filter()
                ->map(fn (string $path) => asset($path))
                ->values();
        @endphp

        @if ($galleryUrls->isNotEmpty())
            <div x-data="{ active: 0, images: @js($galleryUrls->all()), count: @js($galleryUrls->count()) }">
                <div class="crop-frame overflow-hidden rounded-3xl border border-ink-300 bg-ink-100 dark:border-ink-700 dark:bg-ink-900">
                    <div class="relative aspect-video">
                        <template x-for="(img, i) in images" :key="i">
                            <img
                                :src="img"
                                :class="i === active ? 'opacity-100' : 'pointer-events-none absolute inset-0 opacity-0'"
                                class="size-full object-cover transition-opacity duration-500"
                                alt=""
                                loading="lazy"
                                x-cloak
                            />
                        </template>
                        <span class="absolute right-4 top-4 rounded-md bg-ink-950/70 px-2.5 py-1 font-mono text-[0.68rem] uppercase tracking-[0.12em] text-white backdrop-blur-sm">
                            FIG. 01
                        </span>
                    </div>
                </div>

                @if ($galleryUrls->count() > 1)
                    <div class="mt-3 flex gap-3">
                        <template x-for="(img, i) in images" :key="i">
                            <button
                                type="button"
                                @click="active = i"
                                :class="i === active ? 'ring-2 ring-emerald-400 ring-offset-2 ring-offset-white dark:ring-offset-ink-950' : 'opacity-60 hover:opacity-100'"
                                class="w-24 overflow-hidden rounded-xl border border-ink-300 bg-ink-100 transition-all dark:border-ink-700 dark:bg-ink-800"
                                :aria-label="'Aperçu ' + (i + 1)"
                            >
                                <img :src="img" alt="" loading="lazy" class="aspect-video w-full object-cover" />
                            </button>
                        </template>
                    </div>
                @endif
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
                <span class="rounded-md bg-emerald-100 px-2 py-1 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">{{ $project->status->label() }}</span>
                <span class="rounded-md bg-ink-100 px-2 py-1 text-ink-600 dark:bg-ink-800 dark:text-ink-300">{{ $project->complexity->label() }}</span>
            </div>

            <h1 class="mt-5 max-w-3xl font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
                {{ $project->name }}
            </h1>

            @if ($project->description)
                <p class="mt-5 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
                    {{ $project->description }}
                </p>
            @endif
        </div>

        @if ($project->url || $project->repository_url)
            <div class="flex shrink-0 flex-wrap gap-3 lg:justify-end">
                @if ($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                       class="group inline-flex items-center gap-2.5 rounded-full bg-emerald-600 px-6 py-3 font-display text-base font-medium text-white transition-colors hover:bg-emerald-700 dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400">
                        Visiter le site
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:translate-x-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif
                @if ($project->repository_url)
                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-full border border-ink-300 bg-white px-6 py-3 font-display text-base font-medium text-ink-700 transition-colors hover:border-ink-400 hover:bg-ink-50 dark:border-ink-700 dark:bg-ink-950 dark:text-ink-200 dark:hover:border-ink-500 dark:hover:bg-ink-800">
                        Code source
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </header>

    {{-- Compétences mobilisées --}}
    @if ($project->skills->isNotEmpty())
        <section class="mt-12">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">02</span>
                <h2 class="eyebrow">Compétences mobilisées</h2>
            </div>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="inline-flex items-center gap-2 rounded-lg border border-ink-300 bg-white px-3 py-1.5 font-mono text-[0.72rem] uppercase tracking-[0.08em] text-ink-700 dark:border-ink-700 dark:bg-ink-950 dark:text-ink-200">
                        @if ($skill->icon) <x-site-icon :icon="$skill->icon" class="size-4" /> @endif
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Stack du projet --}}
    @if ($project->stack && $project->stack->stackItems->isNotEmpty())
        <section class="mt-14">
            <div class="flex flex-wrap items-baseline justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">03</span>
                    <h2 class="eyebrow">Stack du projet</h2>
                </div>
                <p class="font-mono text-[0.7rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">{{ $project->stack->name }}</p>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                @foreach ($project->stack->stackItems->groupBy('category') as $category => $items)
                    <div class="rounded-2xl border border-ink-300 bg-white p-6 dark:border-ink-700 dark:bg-ink-950">
                        <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($items as $item)
                                <span class="inline-flex items-center gap-1.5 rounded bg-ink-100 px-2 py-1 font-mono text-[0.72rem] text-ink-700 dark:bg-ink-800 dark:text-ink-200">
                                    @if ($item->icon) <x-site-icon :icon="$item->icon" class="size-3.5" /> @endif
                                    {{ $item->value }}@if ($item->version) <span class="text-ink-500 dark:text-ink-500">{{ $item->version }}</span>@endif
                                </span>
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
            <div class="flex items-center gap-3">
                <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">04</span>
                <h2 class="eyebrow">Infrastructure</h2>
            </div>
            <dl class="mt-6 grid gap-px overflow-hidden rounded-2xl border border-ink-300 bg-ink-300/80 sm:grid-cols-3 dark:border-ink-700 dark:bg-ink-700/60">
                <div class="group bg-white p-6 transition-colors hover:bg-emerald-50/50 dark:bg-ink-950 dark:hover:bg-emerald-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">Environnement</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ $project->infra->environment->label() }}</dd>
                </div>
                <div class="bg-white p-6 transition-colors hover:bg-emerald-50/50 dark:bg-ink-950 dark:hover:bg-emerald-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">CPU / RAM</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ $project->infra->cpu_cores }} cœurs · {{ $project->infra->memory_mb }} Mo</dd>
                </div>
                <div class="bg-white p-6 transition-colors hover:bg-emerald-50/50 dark:bg-ink-950 dark:hover:bg-emerald-950/20">
                    <dt class="font-mono text-[0.68rem] uppercase tracking-[0.16em] text-ink-500 dark:text-ink-400">Stockage</dt>
                    <dd class="mt-1.5 font-display text-lg font-medium text-ink-900 dark:text-ink-50">{{ $project->infra->storage_gb }} Go</dd>
                </div>
            </dl>
        </section>
    @endif

    {{-- CTA suivant --}}
    <div class="mt-20 flex flex-wrap items-center justify-between gap-6 rounded-2xl border border-ink-300 bg-emerald-50/50 px-8 py-7 dark:border-ink-700 dark:bg-emerald-950/20">
        <p class="font-display text-xl font-medium tracking-tight text-ink-900 dark:text-ink-50">
            Ce projet vous inspire&nbsp;?
        </p>
        <x-front.arrow-link :href="route('contact')" wire:navigate>
            Parlons du vôtre
        </x-front.arrow-link>
    </div>
</div>