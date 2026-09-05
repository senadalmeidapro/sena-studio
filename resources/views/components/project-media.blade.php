@props(['image' => null, 'label' => 'Projet'])

<div {{ $attributes->merge(['class' => 'relative aspect-video overflow-hidden bg-gradient-to-br from-sage-200 via-sage-100 to-ink-100 dark:from-sage-800/60 dark:via-ink-800 dark:to-ink-900']) }}>
    @if ($image)
        <img src="{{ asset($image) }}" alt="{{ $label }}" loading="lazy"
             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
    @else
        <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-sage-700 dark:text-sage-300">
            {{ mb_substr($label, 0, 1) }}
        </div>
    @endif
</div>