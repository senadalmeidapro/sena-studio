<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\InfrastructureStatusOverviewWidget;
use App\Filament\Widgets\MessagesWidget;
use App\Filament\Widgets\OverviewStatsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use App\Filament\Widgets\ProjectStatusChartWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentProjectsWidget;
use App\Filament\Widgets\SkillsByCategoryChartWidget;
use App\Filament\Widgets\StackDistributionChartWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Tableau de bord';

    public function getWidgets(): array
    {
        return [
            OverviewStatsWidget::class,
            ProjectStatusChartWidget::class,
            StackDistributionChartWidget::class,
            SkillsByCategoryChartWidget::class,
            RecentProjectsWidget::class,
            MessagesWidget::class,
            ProjectsMissingMediaWidget::class,
            InfrastructureStatusOverviewWidget::class,
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
