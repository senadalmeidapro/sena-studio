<?php

namespace App\Filament\Widgets;

use App\Models\Stack;
use Filament\Widgets\BarChartWidget;

class StackDistributionChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Projets par stack';

    protected ?string $description = 'Nombre de projets assignés à chaque stack technique.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 4,
    ];

    protected function getData(): array
    {
        $stacks = Stack::query()
            ->withCount('projects')
            ->orderByDesc('projects_count')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Projets',
                    'data' => $stacks->pluck('projects_count')->all(),
                ],
            ],
            'labels' => $stacks->pluck('name')->all(),
        ];
    }
}
