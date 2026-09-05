<div class="flex items-center">
    @php($icon = $record['icon'] ?? null)
    @if ($icon)
        @if (str_starts_with((string) $icon, 'http://') || str_starts_with((string) $icon, 'https://'))
            <img src="{{ $icon }}" alt="" loading="lazy" referrerpolicy="no-referrer"
                 class="size-6"
                 onerror="this.style.display='none'" />
        @else
            <span class="text-base leading-none">{{ $icon }}</span>
        @endif
    @endif
</div>