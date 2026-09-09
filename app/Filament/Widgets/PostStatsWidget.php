<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Articles';

    protected ?string $description = 'État de la vitrine éditoriale.';

    protected function getStats(): array
    {
        $total = Post::query()->count();
        $published = Post::query()->where('status', Post::STATUS_PUBLISHED)->count();
        $drafts = Post::query()->where('status', Post::STATUS_DRAFT)->count();
        $thisMonth = Post::query()
            ->where('status', Post::STATUS_PUBLISHED)
            ->where('published_at', '>=', now()->startOfMonth())
            ->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Articles enregistrés')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Publiés', number_format($published))
                ->description('En ligne')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Brouillons', number_format($drafts))
                ->description('En préparation')
                ->descriptionIcon('heroicon-m-pencil')
                ->color('warning'),

            Stat::make('Publiés ce mois', number_format($thisMonth))
                ->description('Depuis le 1er')
                ->descriptionIcon('heroicon-m-fire')
                ->color('info'),
        ];
    }
}
