<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\DoughnutChartWidget;

class VisitsByLocaleChartWidget extends DoughnutChartWidget
{
    protected ?string $heading = 'Visites par langue';

    protected ?string $description = 'Répartition FR / EN sur les 30 derniers jours.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 4,
    ];

    protected function getData(): array
    {
        $counts = PageView::query()
            ->public()
            ->since(30)
            ->get(['locale'])
            ->groupBy(fn (PageView $view): string => $view->locale ?: 'fr')
            ->map->count();

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => [
                        (int) ($counts['en'] ?? 0),
                        (int) ($counts['fr'] ?? 0),
                    ],
                ],
            ],
            'labels' => ['English', 'Français'],
        ];
    }
}
