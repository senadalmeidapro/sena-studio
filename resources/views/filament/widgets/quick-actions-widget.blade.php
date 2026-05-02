<x-filament-widgets::widget>
    <x-filament::section
        heading="Quick Actions"
        description="Direct entry points for common SaaS control-center operations."
    >
        <div class="flex flex-wrap gap-3">
            @foreach ($actions as $action)
                <x-filament::button
                    :href="$action['url']"
                    tag="a"
                >
                    {{ $action['label'] }}
                </x-filament::button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
