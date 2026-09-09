<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminActivityChartWidget;
use App\Filament\Widgets\InfrastructureStatusOverviewWidget;
use App\Filament\Widgets\MessagesWidget;
use App\Filament\Widgets\OverviewStatsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use App\Filament\Widgets\ProjectStatusChartWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\RecentProjectsWidget;
use App\Filament\Widgets\SkillLevelChartWidget;
use App\Filament\Widgets\StackDistributionChartWidget;
use App\Filament\Widgets\TopPagesChartWidget;
use App\Filament\Widgets\TrafficStatsWidget;
use App\Filament\Widgets\VisitsByLocaleChartWidget;
use App\Filament\Widgets\VisitsChartWidget;
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
            TrafficStatsWidget::class,
            VisitsChartWidget::class,
            VisitsByLocaleChartWidget::class,
            TopPagesChartWidget::class,
            AdminActivityChartWidget::class,
            ProjectStatusChartWidget::class,
            StackDistributionChartWidget::class,
            SkillLevelChartWidget::class,
            RecentProjectsWidget::class,
            MessagesWidget::class,
            ProjectsMissingMediaWidget::class,
            InfrastructureStatusOverviewWidget::class,
            RecentActivityWidget::class,
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
