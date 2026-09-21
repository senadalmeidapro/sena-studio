<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\LineChartWidget;

class VisitsChartWidget extends LineChartWidget
{
    protected ?string $heading = 'Visites · 30 derniers jours';

    protected ?string $description = 'Pages vues quotidiennes (hors bots).';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 8,
    ];

    protected function getData(): array
    {
        $start = now()->subDays(29)->startOfDay();

        $views = PageView::query()
            ->public()
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as aggregate')
            ->groupByRaw('DATE(created_at)')
            ->pluck('aggregate', 'day');

        $labels = [];
        $data = [];

        for ($i = 29; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $key = $day->format('Y-m-d');
            $labels[] = $day->translatedFormat('d M');
            $data[] = (int) ($views[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Vues',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
