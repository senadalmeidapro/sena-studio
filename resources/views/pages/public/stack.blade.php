<div class="mx-auto max-w-6xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">

    <header class="mb-12 motion-safe:animate-fade-up">
        <h1 class="text-balance text-3xl font-semibold tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">Stack technique</h1>
        <p class="mt-3 max-w-2xl text-pretty text-ink-600 dark:text-ink-300">
            Les briques technologiques que j'utilise pour concevoir, développer et faire évoluer des applications fiables.
        </p>
    </header>

    @foreach ($this->stacks as $stack)
        <section class="mb-12 rounded-2xl border border-ink-200/80 bg-white/70 p-6 shadow-sm shadow-sage-500/5 sm:p-8 dark:border-ink-800 dark:bg-ink-900/50">
            <div class="mb-1 flex flex-wrap items-center gap-3">
                <h2 class="text-xl font-semibold text-ink-900 dark:text-ink-50">{{ $stack->name }}</h2>
                @if ($stack->projects->isNotEmpty())
                    <span class="rounded-md bg-ink-100 px-2 py-0.5 text-xs text-ink-500 dark:bg-ink-800 dark:text-ink-400">
                        {{ $stack->projects->count() }} projet{{ $stack->projects->count() > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
            @if ($stack->description)
                <p class="text-sm text-ink-500 dark:text-ink-400">{{ $stack->description }}</p>
            @endif

            @if ($stack->stackItems->isNotEmpty())
                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    @foreach ($stack->stackItems->groupBy('category') as $category => $items)
                        <div>
                            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-sage-600 dark:text-sage-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                            <div class="space-y-2">
                                @foreach ($items as $item)
                                    <div class="flex items-center justify-between rounded-lg border border-ink-200/80 bg-white/80 px-4 py-2.5 transition-colors hover:border-sage-400/50 dark:border-ink-800 dark:bg-ink-900/60 dark:hover:border-sage-500/40">
                                        <span class="flex items-center gap-2 text-sm text-ink-800 dark:text-ink-100">
                                            <span class="flex min-w-5 items-center justify-center">
                                                @if ($item->icon)
                                                    <x-site-icon :icon="$item->icon" class="size-5" />
                                                @endif
                                            </span>
                                            {{ $item->value }}
                                        </span>
                                        @if ($item->version)
                                            <span class="text-xs text-ink-500 dark:text-ink-500">{{ $item->version }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach

    @if ($this->stacks->isEmpty())
        <div class="rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            Aucune stack publiée pour le moment.
        </div>
    @endif
</div>