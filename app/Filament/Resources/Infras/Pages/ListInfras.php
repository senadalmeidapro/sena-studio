<?php

namespace App\Filament\Resources\Infras\Pages;

use App\Filament\Resources\Infras\InfraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfras extends ListRecords
{
    protected static string $resource = InfraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
