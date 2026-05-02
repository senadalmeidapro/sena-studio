<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\InfrastructureStatusOverviewWidget;
use App\Filament\Widgets\OverviewStatsWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\SkillsByCategoryChartWidget;
use App\Filament\Widgets\StackDistributionChartWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Control Center';

    public function getWidgets(): array
    {
        return [
            OverviewStatsWidget::class,
            QuickActionsWidget::class,
            SkillsByCategoryChartWidget::class,
            StackDistributionChartWidget::class,
            InfrastructureStatusOverviewWidget::class,
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
