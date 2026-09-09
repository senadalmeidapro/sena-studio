<?php

namespace App\Filament\Widgets;

use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestimonialStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Témoignages';

    protected ?string $description = 'Preuve sociale affichée sur le site.';

    protected function getStats(): array
    {
        $total = Testimonial::query()->count();
        $visible = Testimonial::query()->where('is_visible', true)->count();
        $hidden = Testimonial::query()->where('is_visible', false)->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Témoignages enregistrés')
                ->descriptionIcon('heroicon-m-star')
                ->color('primary'),

            Stat::make('Affichés', number_format($visible))
                ->description('Visibles sur le site')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Masqués', number_format($hidden))
                ->description('En attente / archivés')
                ->descriptionIcon('heroicon-m-eye-slash')
                ->color('gray'),
        ];
    }
}
