<?php

namespace App\Filament\Widgets;

use App\Models\AdminActivityLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuditLogStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Journal d’activité';

    protected ?string $description = 'Traçabilité des actions dans le panneau.';

    protected function getStats(): array
    {
        $today = AdminActivityLog::query()->whereDate('created_at', today())->count();
        $sevenDays = AdminActivityLog::query()->where('created_at', '>=', now()->subDays(7))->count();
        $total = AdminActivityLog::query()->count();
        $users = AdminActivityLog::query()->whereNotNull('user_id')->distinct('user_id')->count('user_id');

        return [
            Stat::make('Aujourd’hui', number_format($today))
                ->description('Actions enregistrées')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('info'),

            Stat::make('7 derniers jours', number_format($sevenDays))
                ->description('Activité récente')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Total', number_format($total))
                ->description('Événements tracés')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),

            Stat::make('Utilisateurs actifs', number_format($users))
                ->description('Admins ayant agi')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
