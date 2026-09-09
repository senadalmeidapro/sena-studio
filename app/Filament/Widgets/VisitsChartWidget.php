<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Collection;

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
            ->get(['created_at'])
            ->groupBy(fn (PageView $view): string => $view->created_at->format('Y-m-d'))
            ->map(fn (Collection $day): int => $day->count());

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
