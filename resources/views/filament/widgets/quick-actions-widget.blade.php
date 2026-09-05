<x-filament-widgets::widget>
    <x-filament::section
        heading="Actions rapides"
        description="Points d’entrée directs pour les opérations courantes."
    >
        <div class="flex flex-wrap gap-3">
            @foreach ($actions as $action)
                <x-filament::button
                    :href="$action['url']"
                    :color="$action['color'] ?? 'primary'"
                    tag="a"
                >
                    {{ $action['label'] }}
                </x-filament::button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>