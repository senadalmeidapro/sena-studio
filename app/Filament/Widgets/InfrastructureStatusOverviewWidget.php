<?php

namespace App\Filament\Widgets;

use App\Enums\InfraEnvironment;
use App\Models\Infra;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InfrastructureStatusOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Infrastructure';

    protected ?string $description = 'Santé et capacité provisionnée des environnements.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 8,
    ];

    protected function getStats(): array
    {
        return [
            Stat::make('Infras actives', number_format(Infra::query()->where('is_active', true)->count()))
                ->description('Profils disponibles')
                ->color('success'),
            Stat::make('Infras inactives', number_format(Infra::query()->where('is_active', false)->count()))
                ->description('Profils désactivés')
                ->color('danger'),
            Stat::make('Production', number_format(Infra::query()->where('environment', InfraEnvironment::Production->value)->count()))
                ->description('Environnements prêts pour la prod')
                ->color('warning'),
            Stat::make('Cœurs CPU', number_format((int) Infra::query()->sum('cpu_cores')))
                ->description('Calcul provisionné')
                ->color('info'),
            Stat::make('Mémoire', number_format((int) Infra::query()->sum('memory_mb')).' Mo')
                ->description('RAM provisionnée')
                ->color('gray'),
            Stat::make('Stockage', number_format((int) Infra::query()->sum('storage_gb')).' Go')
                ->description('Espace provisionné')
                ->color('primary'),
        ];
    }
}
