<?php

namespace App\Filament\Widgets;

use App\Models\Stack;
use Filament\Widgets\BarChartWidget;

class StackDistributionChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Business: Stack Distribution per Project';

    protected ?string $description = 'Projects grouped by their assigned stack.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 6,
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
                    'label' => 'Projects',
                    'data' => $stacks->pluck('projects_count')->all(),
                ],
            ],
            'labels' => $stacks->pluck('name')->all(),
        ];
    }
}
