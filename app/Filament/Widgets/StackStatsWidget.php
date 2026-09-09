<?php

namespace App\Filament\Widgets;

use App\Models\Stack;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StackStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Stacks techniques';

    protected ?string $description = 'Écosystème technique couvert.';

    protected function getStats(): array
    {
        $total = Stack::query()->count();
        $active = Stack::query()->where('is_active', true)->count();
        $items = Stack::query()->withCount('stackItems')->get()->sum('stack_items_count');
        $projects = Stack::query()->withCount('projects')->get()->sum('projects_count');

        return [
            Stat::make('Total', number_format($total))
                ->description('Stacks référencées')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Actives', number_format($active))
                ->description('Affichées sur le site')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Composants', number_format($items))
                ->description('Items de stack listés')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),

            Stat::make('Projets liés', number_format($projects))
                ->description('Assignés à une stack')
                ->descriptionIcon('heroicon-m-link')
                ->color('gray'),
        ];
    }
}
