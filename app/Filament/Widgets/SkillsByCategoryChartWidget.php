<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\BarChartWidget;

class SkillsByCategoryChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Compétences par catégorie';

    protected ?string $description = 'Répartition des compétences par catégorie assignée.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 4,
    ];

    protected function getData(): array
    {
        $categories = Category::query()
            ->withCount('skills')
            ->orderByDesc('skills_count')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Compétences',
                    'data' => $categories->pluck('skills_count')->all(),
                ],
            ],
            'labels' => $categories->pluck('name')->all(),
        ];
    }
}
