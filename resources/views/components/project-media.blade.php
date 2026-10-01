@props(['image' => null, 'label' => 'Projet'])

<div {{ $attributes->merge(['class' => 'relative aspect-video overflow-hidden bg-surface-muted ']) }}>
    @if ($image)
        <img src="{{ media_url($image, 'f_auto,q_auto,w_960') }}" alt="{{ $label }}" loading="lazy" decoding="async"
             class="project-media-image h-full w-full object-cover" />
    @else
        <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-text-muted ">
            {{ mb_substr($label, 0, 1) }}
        </div>
    @endif
</div>
