<x-filament-widgets::widget>
    <x-filament::section
        heading="Activité récente"
        description="Dernières actions réalisées dans le panneau."
    >
        <x-slot name="footer">
            <x-filament::button
                tag="a"
                href="{{ $resourceUrl }}"
                icon="heroicon-m-arrow-long-right"
                icon-position="after"
                size="sm"
                color="primary"
            >
                Journal complet
            </x-filament::button>
        </x-slot>

        @if ($activities->isNotEmpty())
            <ol style="display:flex;flex-direction:column;gap:.4rem;">
                @foreach ($activities as $activity)
                    <li style="display:flex;align-items:flex-start;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--gray-200);">
                        <span
                            style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;flex-shrink:0;color:white;background:{{ \App\Support\Activity::color($activity->action) }};"
                        >
                            <x-filament::icon
                                :icon="\App\Support\Activity::icon($activity->action)"
                                style="width:1rem;height:1rem;"
                            />
                        </span>

                        <div style="flex:1;min-width:0;">
                            <span
                                style="display:block;font-size:.85rem;font-weight:600;color:var(--gray-950);"
                            >
                                @if ($activity->description)
                                    {{ $activity->description }}
                                @else
                                    {{ $activity->action }}
                                @endif
                            </span>
                            <span style="font-size:.75rem;color:var(--gray-400);">
                                {{ $activity->user?->name ?? '—' }} · {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ol>
        @else
            <x-filament::empty-state
                icon="heroicon-m-clock"
                heading="Aucune activité"
                description="Les actions réalisées dans le panneau apparaîtront ici."
            />
        @endif
    </x-filament::section>
</x-filament-widgets::widget>