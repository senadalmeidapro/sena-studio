@props([
    'index' => null,
    'label' => null,
    'title' => null,
    'subtitle' => null,
    'align' => 'start', // start | center | between
    'actionHref' => null,
    'actionLabel' => null,
    'class' => null,
])

<div @class(['mb-10 flex flex-col gap-4 md:mb-14', $align === 'center' ? 'mx-auto items-center text-center' : '', $class])>
    <div @class(['flex w-full items-center gap-3', $align === 'center' ? 'justify-center' : ''])>
        @if ($index)
            <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-emerald-600 px-2 font-mono text-[0.68rem] font-semibold tabular-nums text-white dark:bg-emerald-500 dark:text-emerald-950">
                {{ $index }}
            </span>
        @endif
        <span class="eyebrow">{{ $label }}</span>
        @if ($align !== 'center')
            <span aria-hidden="true" class="h-px min-w-8 flex-1 bg-ink-300 dark:bg-ink-700"></span>
        @endif
    </div>

    <div @class(['flex w-full flex-col gap-6', $align === 'between' ? 'sm:flex-row sm:items-end sm:justify-between' : '', $align === 'center' ? 'items-center' : ''])>
        <div @class(['max-w-2xl', $align === 'center' ? 'mx-auto' : ''])>
            @if ($title)
                <h2 class="font-display text-3xl font-medium tracking-tight text-ink-900 dark:text-ink-50 sm:text-4xl">
                    {{ $title }}
                </h2>
            @endif
            @if ($subtitle)
                <p class="mt-3 text-pretty text-ink-600 dark:text-ink-400">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        @if ($actionHref && $actionLabel)
            <x-front.arrow-link :href="$actionHref" wire:navigate class="shrink-0">
                {{ $actionLabel }}
            </x-front.arrow-link>
        @endif
    </div>
</div>