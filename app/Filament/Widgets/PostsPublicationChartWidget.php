<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\BarChartWidget;

class PostsPublicationChartWidget extends BarChartWidget
{
    protected ?string $heading = 'Publications · 12 derniers mois';

    protected ?string $description = 'Articles publiés par mois.';

    protected function getData(): array
    {
        $start = now()->subMonths(11)->startOfMonth();

        $perMonth = Post::query()
            ->where('status', Post::STATUS_PUBLISHED)
            ->where('published_at', '>=', $start)
            ->get(['published_at'])
            ->groupBy(fn (Post $post): string => $post->published_at->format('Y-m'))
            ->map->count();

        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $key = $month->format('Y-m');
            $labels[] = ucfirst($month->translatedFormat('M Y'));
            $data[] = (int) ($perMonth[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Articles',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
