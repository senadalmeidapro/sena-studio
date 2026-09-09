<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Portefeuille';

    protected ?string $description = 'Suivi du cycle de vie des projets.';

    protected function getStats(): array
    {
        $total = Project::query()->count();
        $production = Project::query()->where('status', ProjectStatus::Production)->count();
        $public = Project::query()->where('visibility', ProjectVisibility::Public)->count();
        $started = Project::query()->where('status', '!=', ProjectStatus::Cancelled)->where('started_at', '>=', now()->startOfYear())->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Projets référencés')
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary'),

            Stat::make('En production', number_format($production))
                ->description('Disponibles publiquement')
                ->descriptionIcon('heroicon-m-rocket-launch')
                ->color('success'),

            Stat::make('Visibilité publique', number_format($public))
                ->description('Clients / open source')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Démarrés cette année', number_format($started))
                ->description('Hors annulés')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),
        ];
    }
}
