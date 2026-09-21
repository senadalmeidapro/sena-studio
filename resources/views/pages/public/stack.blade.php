<div class="public-page mx-auto max-w-7xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pt-20">

    {{-- En-tête éditorial --}}
    <header class="border-b border-ink-300 pb-10 motion-safe:animate-fade-up dark:border-ink-700">
        <div class="flex items-center gap-3">
            <span class="eyebrow">{{ __('stack.eyebrow') }}</span>
        </div>
        <h1 class="mt-5 font-display text-4xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-5xl">
            {{ __('stack.title') }}
        </h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-ink-600 dark:text-ink-300">
            {{ __('stack.subtitle') }}
        </p>
    </header>

    <section class="mt-10 rounded-xl border border-ink-300 bg-card p-6 dark:border-ink-700 sm:p-8">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_1fr] lg:items-end">
            <div>
                <p class="eyebrow">{{ __('stack.signal_title') }}</p>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-600 dark:text-ink-400">{{ __('stack.signal_text') }}</p>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ([__('stack.signal_interface'), __('stack.signal_core'), __('stack.signal_data'), __('stack.signal_delivery')] as $label)
                    <div class="border-l border-ink-200 pl-3 dark:border-ink-700">
                        <span class="block size-2 rounded-full bg-blue-500"></span>
                        <p class="mt-3 text-xs font-medium text-ink-700 dark:text-ink-200">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="mt-14 space-y-14">
        @foreach ($this->stacks as $stack)
            <section>
                <div class="mb-6 flex flex-wrap items-baseline gap-4">
                    <h2 class="font-display text-2xl font-medium tracking-tight text-ink-900 dark:text-ink-50">{{ $stack->name }}</h2>
                    @if ($stack->projects->isNotEmpty())
                        <span class="font-mono text-[0.7rem] uppercase tracking-[0.14em] text-ink-400 dark:text-ink-500">
                            {{ $stack->projects->count() }} {{ $stack->projects->count() > 1 ? __('common.projects_count_plural_unit') : __('common.projects_count_unit') }}
                        </span>
                    @endif
                    <span aria-hidden="true" class="hidden h-px min-w-8 flex-1 bg-ink-300 sm:block dark:bg-ink-700"></span>
                </div>

                @if ($stack->description)
                    <p class="mb-6 max-w-2xl text-pretty text-ink-600 dark:text-ink-400">{{ $stack->description }}</p>
                @endif

                @if ($stack->stackItems->isNotEmpty())
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach ($stack->stackItems->groupBy('category') as $category => $items)
                            <div class="rounded-2xl border border-ink-300 bg-card p-6 shadow-soft dark:border-ink-700">
                                <h3 class="mb-4 font-mono text-[0.68rem] uppercase tracking-[0.2em] text-blue-600 dark:text-blue-300">{{ \App\Enums\StackItemCategory::from($category)->label() }}</h3>
                                <div class="space-y-2">
                                    @foreach ($items as $item)
                                        <div class="flex items-center justify-between rounded-lg border border-ink-300 px-4 py-2.5 transition-colors hover:border-blue-400/50 dark:border-ink-700 dark:hover:border-blue-500/40">
                                            <span class="flex items-center gap-2 text-sm text-ink-800 dark:text-ink-100">
                                                <span class="flex min-w-5 items-center justify-center">
                                                    @if ($item->icon)
                                                        <x-site-icon :icon="$item->icon" class="size-5" />
                                                    @endif
                                                </span>
                                                @if (in_array($item->value, $this->skillNames, true))
                                                    <a href="{{ skill_url($item->value) }}" class="transition-colors hover:text-blue-700 dark:hover:text-blue-300">{{ $item->value }}</a>
                                                @else
                                                    {{ $item->value }}
                                                @endif
                                            </span>
                                            @if ($item->version)
                                                <span class="font-mono text-xs tabular-nums text-ink-500 dark:text-ink-500">{{ $item->version }}</span>
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
    </div>

    @if ($this->stacks->isEmpty())
        <div class="mt-12 rounded-2xl border border-dashed border-ink-300 p-12 text-center text-ink-500 dark:border-ink-700 dark:text-ink-400">
            {{ __('stack.empty') }}
        </div>
    @endif
</div>
