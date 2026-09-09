<?php

namespace App\Filament\Widgets;

use App\Models\AdminActivityLog;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Collection;

class AdminActivityChartWidget extends LineChartWidget
{
    protected ?string $heading = 'Activité admin · 14 derniers jours';

    protected ?string $description = 'Actions réalisées dans le panneau d’administration.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 6,
    ];

    protected function getData(): array
    {
        $start = now()->subDays(13)->startOfDay();

        $actions = AdminActivityLog::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn (AdminActivityLog $log): string => $log->created_at->format('Y-m-d'))
            ->map(fn (Collection $day): int => $day->count());

        $labels = [];
        $data = [];

        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $key = $day->format('Y-m-d');
            $labels[] = $day->translatedFormat('d M');
            $data[] = (int) ($actions[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Actions',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
