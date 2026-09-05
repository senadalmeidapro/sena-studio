<x-filament-widgets::widget>
    <x-filament::section
        heading="Projets sans aperçu"
        description="À compléter : ajoutez une image de couverture ou des aperçus."
    >
        @if ($projects->isNotEmpty())
            <ul class="divide-y divide-gray-200 dark:divide-white/10">
                @foreach ($projects as $project)
                    <li class="flex items-center justify-between gap-3 py-2.5">
                        <span class="truncate text-sm text-gray-700 dark:text-gray-200">{{ $project->name }}</span>
                        <a
                            href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project]) }}"
                            class="shrink-0 text-xs font-medium text-sage-600 hover:underline dark:text-sage-300"
                        >
                            Ajouter →
                        </a>
                    </li>
                @endforeach
            </ul>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                {{ $projects->count() }} projet{{ $projects->count() > 1 ? 's' : '' }} à illustrer.
            </p>
        @else
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">
                Tous les projets ont un aperçu. 
            </p>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>