<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\BarChartWidget;

class TopPagesChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Pages les plus visitées';

    protected ?string $description = 'Top 10 des pages publiques sur 30 jours.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 6,
    ];

    protected function getData(): array
    {
        $pages = PageView::query()
            ->public()
            ->since(30)
            ->get(['path'])
            ->groupBy('path')
            ->map->count()
            ->sortDesc()
            ->take(10);

        return [
            'datasets' => [
                [
                    'label' => 'Vues',
                    'data' => $pages->values()->all(),
                ],
            ],
            'labels' => $pages->keys()->map(fn (string $path): string => mb_strlen($path) > 30 ? '…'.mb_substr($path, -29) : $path)->all(),
        ];
    }
}
