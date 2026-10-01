<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ContactPipelineWidget;
use App\Filament\Widgets\NewLeadsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Tableau de bord';

    protected static UnitEnum|string|null $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            NewLeadsWidget::class,
            ContactPipelineWidget::class,
            ProjectsMissingMediaWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 2,
            'xl' => 12,
        ];
    }
}
