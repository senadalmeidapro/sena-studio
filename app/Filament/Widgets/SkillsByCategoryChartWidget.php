<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\BarChartWidget;

class SkillsByCategoryChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Analytics: Skills by Category';

    protected ?string $description = 'Distribution of skills across assigned categories.';

    protected int | string | array $columnSpan = 'full';

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
                    'label' => 'Skills',
                    'data' => $categories->pluck('skills_count')->all(),
                ],
            ],
            'labels' => $categories->pluck('name')->all(),
        ];
    }
}
