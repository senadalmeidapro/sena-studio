<?php

namespace App\Filament\Widgets;

use App\Enums\CvStatus;
use App\Models\Cv;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CvStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Curriculum Vitae';

    protected ?string $description = 'Versions de CV et leur disponibilité.';

    protected function getStats(): array
    {
        $total = Cv::query()->count();
        $published = Cv::query()->where('status', CvStatus::Published)->count();
        $drafts = Cv::query()->where('status', CvStatus::Draft)->count();
        $primary = Cv::primary()->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Versions enregistrées')
                ->descriptionIcon('heroicon-m-document')
                ->color('primary'),

            Stat::make('Publiés', number_format($published))
                ->description('Accessibles publiquement')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),

            Stat::make('Brouillons', number_format($drafts))
                ->description('Non publiés')
                ->descriptionIcon('heroicon-m-pencil')
                ->color('warning'),

            Stat::make('Version principale', number_format($primary))
                ->description('Servie par défaut')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),
        ];
    }
}
