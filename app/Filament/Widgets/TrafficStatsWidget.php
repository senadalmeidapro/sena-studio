<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrafficStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Trafic public';

    protected ?string $description = 'Fréquentation du site (hors bots).';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = PageView::query()
            ->public()
            ->where('created_at', '>=', today())
            ->count();

        $todayUnique = PageView::query()
            ->public()
            ->where('created_at', '>=', today())
            ->distinct('ip_hash')
            ->count('ip_hash');

        $sevenDays = PageView::query()
            ->public()
            ->since(7)
            ->count();

        $thirtyDays = PageView::query()
            ->public()
            ->since(30)
            ->count();

        return [
            Stat::make('Vues aujourd’hui', number_format($today))
                ->description('Pages vues')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            Stat::make('Visiteurs uniques', number_format($todayUnique))
                ->description('Aujourd’hui')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Vues · 7 jours', number_format($sevenDays))
                ->description('Dernière semaine')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),

            Stat::make('Vues · 30 jours', number_format($thirtyDays))
                ->description('Dernier mois')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('gray'),
        ];
    }
}
