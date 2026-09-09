<?php

namespace App\Filament\Widgets;

use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SkillStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Compétences';

    protected ?string $description = 'Catalogue des compétences maîtrisées.';

    protected function getStats(): array
    {
        $total = Skill::query()->count();
        $active = Skill::query()->where('is_active', true)->count();
        $expert = Skill::query()->where('level', 'expert')->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Compétences listées')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),

            Stat::make('Actives', number_format($active))
                ->description('Affichées sur le site')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Expertise', number_format($expert))
                ->description('Niveau expert')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('info'),
        ];
    }
}
