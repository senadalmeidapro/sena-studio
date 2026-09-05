<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\ContactMessageResource;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! $this->record->isRead()) {
            $this->record->markAsRead();
        }
    }
}
