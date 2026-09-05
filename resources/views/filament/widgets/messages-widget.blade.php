<x-filament-widgets::widget>
    <x-filament::section
        heading="Messages"
        description="Dernières demandes reçues via le formulaire de contact."
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
                Tous les messages
            </x-filament::button>
        </x-slot>

        @if ($messages->isNotEmpty())
            <ul style="display:flex;flex-direction:column;">
                @foreach ($messages as $message)
                    <li style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-top:1px solid var(--gray-200);">
                        <span
                            style="display:inline-flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:9999px;font-size:.8rem;font-weight:600;color:{{ $message->isRead() ? 'var(--gray-400)' : 'var(--primary-700)' }};background:{{ $message->isRead() ? 'var(--gray-100)' : 'var(--primary-100)' }};"
                        >
                            {{ strtoupper(mb_substr($message->name, 0, 1)) }}
                        </span>

                        <div style="flex:1;min-width:0;">
                            <a
                                href="{{ \App\Filament\Resources\Messages\ContactMessageResource::getUrl('view', ['record' => $message]) }}"
                                style="display:block;font-size:.85rem;font-weight:600;color:var(--gray-950);text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                            >
                                {{ $message->name }} — {{ $message->subject }}
                            </a>
                            <span style="font-size:.75rem;color:var(--gray-400);">
                                {{ $message->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if (! $message->isRead())
                            <x-filament::icon-button
                                wire:click="markAsRead({{ $message->id }})"
                                icon="heroicon-o-check"
                                color="primary"
                                size="sm"
                                tooltip="Marquer comme lu"
                            />
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <x-filament::empty-state
                icon="heroicon-m-envelope"
                heading="Aucun message"
                description="Les demandes envoyées via le formulaire de contact apparaîtront ici."
            />
        @endif
    </x-filament::section>
</x-filament-widgets::widget>