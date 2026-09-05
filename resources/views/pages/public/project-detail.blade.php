<div class="mx-auto max-w-4xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">

    <a href="{{ route('projects.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-ink-500 transition-colors hover:text-sage-600 dark:text-ink-400 dark:hover:text-sage-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5m5.25 15L8.25 12l7.5-7.5" />
        </svg>
        Retour aux projets
    </a>

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
                <div class="overflow-hidden rounded-3xl border border-ink-200/80 shadow-lg shadow-sage-500/10 dark:border-ink-800">
                    <div class="relative aspect-video bg-gradient-to-br from-sage-200 via-sage-100 to-ink-100 dark:from-sage-800/60 dark:via-ink-800 dark:to-ink-900">
                        <template x-for="(img, i) in images" :key="i">
                            <img
                                :src="img"
                                :class="i === active ? 'opacity-100' : 'pointer-events-none absolute inset-0 opacity-0'"
                                class="size-full object-cover"
                                alt=""
                                loading="lazy"
                                x-cloak
                            />
                        </template>
                    </div>
                </div>

                @if ($galleryUrls->count() > 1)
                    <div class="mt-3 flex gap-3">
                        <template x-for="(img, i) in images" :key="i">
                            <button
                                type="button"
                                @click="active = i"
                                :class="i === active ? 'ring-2 ring-sage-500 ring-offset-2 ring-offset-white dark:ring-offset-ink-950' : 'opacity-70 hover:opacity-100'"
                                class="w-24 overflow-hidden rounded-xl border border-ink-200/80 bg-ink-100 transition-all dark:border-ink-700 dark:bg-ink-800"
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

    <header class="mt-10 motion-safe:animate-fade-up [animation-delay:160ms]">
        <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-md bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-700 dark:bg-ink-800 dark:text-ink-300">{{ $project->type->label() }}</span>
            <span class="rounded-md bg-sage-100 px-2.5 py-1 text-xs font-medium text-sage-700 dark:bg-sage-500/15 dark:text-sage-300">{{ $project->status->label() }}</span>
            <span class="rounded-md bg-ink-100 px-2.5 py-1 text-xs font-medium text-ink-700 dark:bg-ink-800 dark:text-ink-300">{{ $project->complexity->label() }}</span>
        </div>

        <h1 class="mt-4 text-balance text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">{{ $project->name }}</h1>

        @if ($project->description)
            <p class="mt-4 text-lg leading-relaxed text-ink-600 dark:text-ink-300">{{ $project->description }}</p>
        @endif

        @if ($project->url || $project->repository_url)
            <div class="mt-6 flex flex-wrap gap-3">
                @if ($project->url)
                    <flux:button variant="primary" size="base" href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="rounded-lg">
                        Visiter le site
                    </flux:button>
                @endif
                @if ($project->repository_url)
                    <flux:button variant="subtle" size="base" href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-ink-300 dark:border-ink-700">
                        Code source
                    </flux:button>
                @endif
            </div>
        @endif
    </header>

    @if ($project->skills->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-lg font-semibold text-ink-900 dark:text-ink-50">Compétences mobilisées</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-ink-200 bg-white/70 px-3 py-1.5 text-sm text-ink-700 dark:border-ink-700 dark:bg-ink-900/50 dark:text-ink-200">
                        @if ($skill->icon) <x-site-icon :icon="$skill->icon" class="size-4" /> @endif
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </section>
    @endif

    @if ($project->stack && $project->stack->stackItems->isNotEmpty())
        <section class="mt-12">
            <h2 class="text-lg font-semibold text-ink-900 dark:text-ink-50">Stack du projet</h2>
            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ $project->stack->name }}</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                @foreach ($project->stack->stackItems->groupBy('category') as $category => $items)
                    <div class="rounded-xl border border-ink-200/80 bg-white/70 p-5 shadow-sm shadow-sage-500/5 dark:border-ink-800 dark:bg-ink-900/50">
                        <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-sage-600 dark:text-sage-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($items as $item)
                                <span class="inline-flex items-center gap-1.5 rounded bg-ink-100 px-2 py-1 text-xs text-ink-700 dark:bg-ink-800 dark:text-ink-200">
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

    @if ($project->infra)
        <section class="mt-12 rounded-2xl border border-ink-200/80 bg-white/70 p-6 shadow-sm shadow-sage-500/5 dark:border-ink-800 dark:bg-ink-900/50">
            <h2 class="text-lg font-semibold text-ink-900 dark:text-ink-50">Infrastructure</h2>
            <div class="mt-4 grid gap-4 text-sm sm:grid-cols-3">
                <div>
                    <div class="text-ink-500 dark:text-ink-500">Environnement</div>
                    <div class="mt-1 text-ink-800 dark:text-ink-200">{{ $project->infra->environment->label() }}</div>
                </div>
                <div>
                    <div class="text-ink-500 dark:text-ink-500">CPU / RAM</div>
                    <div class="mt-1 text-ink-800 dark:text-ink-200">{{ $project->infra->cpu_cores }} cœurs · {{ $project->infra->memory_mb }} Mo</div>
                </div>
                <div>
                    <div class="text-ink-500 dark:text-ink-500">Stockage</div>
                    <div class="mt-1 text-ink-800 dark:text-ink-200">{{ $project->infra->storage_gb }} Go</div>
                </div>
            </div>
        </section>
    @endif
</div>