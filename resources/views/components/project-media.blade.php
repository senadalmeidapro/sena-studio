@props(['image' => null, 'label' => 'Projet'])

<div {{ $attributes->merge(['class' => 'relative aspect-video overflow-hidden bg-emerald-100 dark:bg-emerald-900/40']) }}>
    @if ($image)
        <img src="{{ asset($image) }}" alt="{{ $label }}" loading="lazy"
             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
    @else
        <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-emerald-700 dark:text-emerald-300">
            {{ mb_substr($label, 0, 1) }}
        </div>
    @endif
</div>