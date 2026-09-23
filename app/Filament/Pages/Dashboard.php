<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ContactPipelineWidget;
use App\Filament\Widgets\InfrastructureStatusOverviewWidget;
use App\Filament\Widgets\MediaHealthWidget;
use App\Filament\Widgets\MessagesWidget;
use App\Filament\Widgets\OverviewStatsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use App\Filament\Widgets\ProjectStatusChartWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\RecentProjectsWidget;
use App\Filament\Widgets\SystemHealthWidget;
use App\Filament\Widgets\TopPagesChartWidget;
use App\Filament\Widgets\TrafficStatsWidget;
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
            SystemHealthWidget::class,
            ContactPipelineWidget::class,
            MessagesWidget::class,
            MediaHealthWidget::class,
            ProjectsMissingMediaWidget::class,
            TrafficStatsWidget::class,
            VisitsChartWidget::class,
            TopPagesChartWidget::class,
            ProjectStatusChartWidget::class,
            RecentProjectsWidget::class,
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
