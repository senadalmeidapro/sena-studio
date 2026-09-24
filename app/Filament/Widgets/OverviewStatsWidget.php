<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Models\ContactMessage;
use App\Models\Cv;
use App\Models\Post;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Vue d’ensemble';

    protected ?string $description = 'Les indicateurs qui demandent une action ou une décision.';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Projets publics', number_format(Project::query()->where('status', ProjectStatus::Production->value)->count()))
                ->description('Projets actuellement visibles')
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary'),
            Stat::make('Messages non lus', number_format(ContactMessage::unread()->count()))
                ->description('Demandes en attente de réponse')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('warning'),
            Stat::make('Relances à venir', number_format(ContactMessage::query()
                ->whereNotNull('follow_up_at')
                ->where('follow_up_at', '<=', now())
                ->whereNotIn('status', [ContactMessage::STATUS_WON, ContactMessage::STATUS_LOST])
                ->count()))
                ->description('Demandes à traiter maintenant')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
            Stat::make('Brouillons', number_format(Post::query()->where('status', Post::STATUS_DRAFT)->count()))
                ->description('Articles à finaliser')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('info'),
            Stat::make('CV principal', number_format(Cv::query()->published()->primary()->count()))
                ->description('Version publiée et active')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('success'),
        ];
    }
}
