<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Widgets\Widget;

class NewLeadsWidget extends Widget
{
    protected string $view = 'filament.widgets.new-leads-widget';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 6,
    ];

    public function getViewData(): array
    {
        return [
            'messages' => ContactMessage::unread()->latest()->take(6)->get(),
            'resourceUrl' => ContactMessageResource::getUrl('index'),
        ];
    }

    public function markAsRead(int $id): void
    {
        ContactMessage::query()
            ->whereKey($id)
            ->whereNull('read_at')
            ->first()?->markAsRead();
    }
}
