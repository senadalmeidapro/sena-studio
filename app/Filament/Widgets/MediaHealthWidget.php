<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MediaHealthWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Santé des médias';

    protected ?string $description = 'Contrôle rapide des couvertures et galeries du portfolio.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 6,
    ];

    protected function getStats(): array
    {
        $projectCovers = Project::query()
            ->whereNotNull('image')
            ->where('image', 'like', 'http%')
            ->count();

        $localCovers = Project::query()
            ->whereNotNull('image')
            ->where('image', 'not like', 'http%')
            ->count();

        $cloudinaryGallery = ProjectImage::query()
            ->where('path', 'like', 'http%')
            ->count();

        $localGallery = ProjectImage::query()
            ->where('path', 'not like', 'http%')
            ->count();

        $cloudinaryConfigured = filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));

        $referencesToRepair = Project::query()
            ->where('image', 'like', 'http%')
            ->whereNull('cloudinary_public_id')
            ->count()
            + ProjectImage::query()
                ->where('path', 'like', 'http%')
                ->whereNull('cloudinary_public_id')
                ->count()
            + Post::query()
                ->where('cover_image', 'like', 'http%')
                ->whereNull('cloudinary_public_id')
                ->count()
            + Testimonial::query()
                ->where('avatar', 'like', 'http%')
                ->whereNull('cloudinary_public_id')
                ->count();

        return [
            Stat::make('Couvertures Cloudinary', number_format($projectCovers))
                ->description($localCovers.' média(s) local(s) ou de démonstration')
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary'),

            Stat::make('Galeries Cloudinary', number_format($cloudinaryGallery))
                ->description($localGallery.' aperçu(s) local(s) ou de démonstration')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('info'),

            Stat::make('Références à réparer', number_format($referencesToRepair))
                ->description($referencesToRepair > 0 ? 'URL Cloudinary sans identifiant enregistré' : 'Toutes les références sont renseignées')
                ->descriptionIcon($referencesToRepair > 0 ? 'heroicon-m-wrench-screwdriver' : 'heroicon-m-check-circle')
                ->color($referencesToRepair > 0 ? 'warning' : 'success'),

            Stat::make('Configuration', $cloudinaryConfigured ? 'Prête' : 'À vérifier')
                ->description($cloudinaryConfigured ? 'Variables Cloudinary présentes' : 'Variables Cloudinary manquantes')
                ->descriptionIcon($cloudinaryConfigured ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                ->color($cloudinaryConfigured ? 'success' : 'danger'),
        ];
    }
}
