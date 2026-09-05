<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Models\ContactMessage;
use App\Models\Infra;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Vue d’ensemble';

    protected ?string $description = 'Indicateurs clés du portefeuille : projets, compétences et communication.';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', number_format(User::query()->count()))
                ->description('Comptes administrateurs')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),

            Stat::make('Projets', number_format(Project::query()->count()))
                ->description('Projets référencés')
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary'),

            Stat::make('Projets en production', number_format(Project::query()->where('status', ProjectStatus::Production->value)->count()))
                ->description('Disponibles publiquement')
                ->descriptionIcon('heroicon-m-rocket-launch')
                ->color('success'),

            Stat::make('Messages non lus', number_format(ContactMessage::unread()->count()))
                ->description('Demandes en attente de réponse')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('warning'),

            Stat::make('Compétences', number_format(Skill::query()->count()))
                ->description('Compétences listées')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Stacks & Infra', number_format(Stack::query()->count() + Infra::query()->count()))
                ->description(Stack::query()->count().' stacks · '.Infra::query()->count().' infra')
                ->descriptionIcon('heroicon-m-cube')
                ->color('gray'),
        ];
    }
}
