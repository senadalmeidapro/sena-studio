<?php

namespace App\Filament\Resources\Engagements\Pages;

use App\Filament\Resources\Engagements\EngagementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEngagements extends ListRecords
{
    protected static string $resource = EngagementResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
