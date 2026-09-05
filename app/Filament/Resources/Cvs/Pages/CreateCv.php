<?php

namespace App\Filament\Resources\Cvs\Pages;

use App\Filament\Resources\Cvs\CvResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCv extends CreateRecord
{
    protected static string $resource = CvResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function afterSave(): void
    {
        if ($this->record->is_primary) {
            $this->record->makePrimary();
        }
    }
}
