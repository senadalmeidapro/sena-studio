<x-filament-widgets::widget>
    <x-filament::section
        heading="Projets récents"
        description="Derniers projets entrés dans le portefeuille."
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
                Tous les projets
            </x-filament::button>
        </x-slot>

        @if ($projects->isNotEmpty())
            <ul style="display:flex;flex-direction:column;">
                @foreach ($projects as $project)
                    <li style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-top:1px solid var(--gray-200);">
                        @if ($project->image)
                            <x-filament::avatar
                                src="{{ asset($project->image) }}"
                                alt="{{ $project->name }}"
                                size="lg"
                            />
                        @else
                            <span
                                style="display:inline-flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:.75rem;font-size:.9rem;font-weight:700;color:var(--primary-600);background:var(--primary-100);"
                            >
                                {{ mb_substr($project->name, 0, 1) }}
                            </span>
                        @endif

                        <div style="flex:1;min-width:0;">
                            <a
                                href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project]) }}"
                                style="display:block;font-size:.85rem;font-weight:600;color:var(--gray-950);text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                            >
                                {{ $project->name }}
                            </a>
                            <span style="font-size:.75rem;color:var(--gray-400);">
                                {{ $project->started_at?->translatedFormat('d M Y') ?? '—' }}
                            </span>
                        </div>

                        <x-filament::badge :color="match ($project->status->value) {
                            'production' => 'success',
                            'testing' => 'warning',
                            'development' => 'info',
                            default => 'gray',
                        }">
                            {{ $project->status->label() }}
                        </x-filament::badge>
                    </li>
                @endforeach
            </ul>
        @else
            <x-filament::empty-state
                icon="heroicon-m-cube"
                heading="Aucun projet"
                description="Les projets créés apparaîtront ici."
            />
        @endif
    </x-filament::section>
</x-filament-widgets::widget>