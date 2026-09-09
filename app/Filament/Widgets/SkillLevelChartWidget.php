<?php

namespace App\Filament\Widgets;

use App\Enums\SkillLevel;
use App\Models\Skill;
use Filament\Widgets\DoughnutChartWidget;

class SkillLevelChartWidget extends DoughnutChartWidget
{
    protected ?string $heading = 'Compétences par niveau';

    protected ?string $description = 'Répartition des compétences par niveau de maîtrise.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 4,
    ];

    protected function getData(): array
    {
        $counts = Skill::query()
            ->get(['level'])
            ->groupBy(fn (Skill $skill): string => $skill->level->value)
            ->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Compétences',
                    'data' => array_map(
                        fn (SkillLevel $level): int => (int) ($counts[$level->value] ?? 0),
                        SkillLevel::cases(),
                    ),
                ],
            ],
            'labels' => array_map(fn (SkillLevel $level): string => $level->label(), SkillLevel::cases()),
        ];
    }
}
