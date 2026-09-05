<div style="display:flex;align-items:center;">
    @php($icon = $record['icon'] ?? null)
    @if ($icon)
        @if (str_starts_with((string) $icon, 'http://') || str_starts_with((string) $icon, 'https://'))
            <img src="{{ $icon }}" alt="" loading="lazy" referrerpolicy="no-referrer"
                 style="width:1.5rem;height:1.5rem;object-fit:contain;"
                 onerror="this.style.display='none'" />
        @else
            <span style="font-size:1rem;line-height:1;">{{ $icon }}</span>
        @endif
    @endif
</div>