<x-filament-widgets::widget>
    <x-filament::section
        heading="Messages"
        description="Dernières demandes reçues via le formulaire de contact."
    >
        <x-slot name="footer">
            <a href="{{ $resourceUrl }}" class="text-sm font-medium text-sage-600 hover:underline dark:text-sage-300">
                Tous les messages →
            </a>
        </x-slot>

        @if ($messages->isNotEmpty())
            <ul class="divide-y divide-gray-200 dark:divide-white/10">
                @foreach ($messages as $message)
                    <li class="flex items-center gap-3 py-3">
                        <span class="{{ $message->isRead() ? 'bg-gray-100 text-gray-400 dark:bg-white/5 dark:text-gray-500' : 'bg-sage-100 text-sage-700 dark:bg-sage-500/15 dark:text-sage-300' }} flex size-9 shrink-0 items-center justify-center rounded-full text-sm font-medium">
                            {{ strtoupper(mb_substr($message->name, 0, 1)) }}
                        </span>

                        <div class="min-w-0 flex-1">
                            <a
                                href="{{ \App\Filament\Resources\Messages\ContactMessageResource::getUrl('view', ['record' => $message]) }}"
                                class="truncate text-sm font-medium text-gray-950 hover:underline dark:text-white"
                            >
                                {{ $message->name }} — {{ $message->subject }}
                            </a>
                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->created_at->diffForHumans() }}
                            </p>
                        </div>

                        @if (! $message->isRead())
                            <button
                                type="button"
                                wire:click="markAsRead({{ $message->id }})"
                                class="rounded-md bg-white p-1.5 text-gray-400 ring-1 ring-inset ring-gray-200 transition-colors hover:text-sage-700 hover:ring-sage-300 dark:bg-white/5 dark:text-gray-500 dark:ring-white/10 dark:hover:text-sage-300 dark:hover:ring-sage-500/50"
                                title="Marquer comme lu"
                            >
                                <x-filament::icon icon="heroicon-m-check" class="size-4" />
                            </button>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">Aucun message reçu.</p>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>