<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MessagesWidget;
use App\Filament\Widgets\OverviewStatsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentProjectsWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\TrafficStatsWidget;
use App\Filament\Widgets\VisitsChartWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Tableau de bord';

    protected static UnitEnum|string|null $navigationGroup = 'Pilotage';

    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            OverviewStatsWidget::class,
            MessagesWidget::class,
            ProjectsMissingMediaWidget::class,
            RecentProjectsWidget::class,
            TrafficStatsWidget::class,
            VisitsChartWidget::class,
            SystemHealthWidget::class,
            QuickActionsWidget::class,
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
