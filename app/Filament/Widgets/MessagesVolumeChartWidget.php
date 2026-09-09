<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\LineChartWidget;

class MessagesVolumeChartWidget extends LineChartWidget
{
    protected ?string $heading = 'Messages · 6 derniers mois';

    protected ?string $description = 'Demandes reçues par mois.';

    protected function getData(): array
    {
        $start = now()->subMonths(5)->startOfMonth();

        $perMonth = ContactMessage::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn (ContactMessage $message): string => $message->created_at->format('Y-m'))
            ->map->count();

        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $key = $month->format('Y-m');
            $labels[] = ucfirst($month->translatedFormat('M Y'));
            $data[] = (int) ($perMonth[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Messages',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
