<?php

namespace App\Filament\Resources\Stacks\Pages;

use App\Filament\Resources\Stacks\StackResource;
use App\Filament\Widgets\StackStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStacks extends ListRecords
{
    protected static string $resource = StackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StackStatsWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 4;
    }
}
