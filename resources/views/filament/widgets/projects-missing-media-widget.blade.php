<x-filament-widgets::widget>
    <x-filament::section
        heading="Projets sans aperçu"
        description="À compléter : ajoutez une image de couverture ou des aperçus."
    >
        @if ($projects->isNotEmpty())
            <ul style="display:flex;flex-direction:column;">
                @foreach ($projects as $project)
                    <li style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:.5rem 0;border-top:1px solid var(--gray-200);">
                        <span style="font-size:.85rem;color:var(--gray-700);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $project->name }}
                        </span>
                        <x-filament::link
                            href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project]) }}"
                            color="primary"
                            size="sm"
                        >
                            Ajouter →
                        </x-filament::link>
                    </li>
                @endforeach
            </ul>
            <p style="margin-top:.5rem;font-size:.75rem;color:var(--gray-400);">
                {{ $projects->count() }} projet{{ $projects->count() > 1 ? 's' : '' }} à illustrer.
            </p>
        @else
            <x-filament::empty-state
                icon="heroicon-m-photo"
                heading="Portefeuille illustré"
                description="Tous les projets ont un aperçu."
            />
        @endif
    </x-filament::section>
</x-filament-widgets::widget>