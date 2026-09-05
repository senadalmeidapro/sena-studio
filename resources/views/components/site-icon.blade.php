@props(['icon' => null, 'class' => 'size-4'])
@if ($icon)
    @if (str_starts_with($icon, 'http://') || str_starts_with($icon, 'https://'))
        <img src="{{ $icon }}" alt="" loading="lazy" referrerpolicy="no-referrer"
             class="{{ $class }}"
             onerror="this.style.display='none'" />
    @else
        <span>{{ $icon }}</span>
    @endif
@endif