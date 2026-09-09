<?php

namespace App\Filament\Resources\Infras\Pages;

use App\Filament\Resources\Infras\InfraResource;
use App\Filament\Widgets\InfrastructureStatusOverviewWidget;
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

    protected function getHeaderWidgets(): array
    {
        return [
            InfrastructureStatusOverviewWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 4;
    }
}
