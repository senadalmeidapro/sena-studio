<x-filament-widgets::widget>
    <x-filament::section
        heading="Projets récents"
        description="Derniers projets entrés dans le portefeuille."
    >
        <x-slot name="footer">
            <a href="{{ $resourceUrl }}" class="text-sm font-medium text-sage-600 hover:underline dark:text-sage-300">
                Tous les projets →
            </a>
        </x-slot>

        @if ($projects->isNotEmpty())
            <ul class="divide-y divide-gray-200 dark:divide-white/10">
                @foreach ($projects as $project)
                    <li class="flex items-center gap-3 py-3">
                        @if ($project->image)
                            <img
                                src="{{ asset($project->image) }}"
                                alt=""
                                loading="lazy"
                                class="size-12 shrink-0 rounded-lg border border-gray-200 bg-gray-100 object-cover dark:border-white/10 dark:bg-white/5"
                            />
                        @else
                            <span class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-sm text-gray-400 dark:bg-white/5 dark:text-gray-500">
                                {{ mb_substr($project->name, 0, 1) }}
                            </span>
                        @endif

                        <div class="min-w-0 flex-1">
                            <a
                                href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project]) }}"
                                class="truncate text-sm font-medium text-gray-950 hover:underline dark:text-white"
                            >
                                {{ $project->name }}
                            </a>
                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                {{ $project->started_at?->translatedFormat('d M Y') ?? '—' }}
                            </p>
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
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">Aucun projet pour le moment.</p>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>