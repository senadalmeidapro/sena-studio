<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactMessageStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Boîte de réception';

    protected ?string $description = 'Suivi des demandes de contact.';

    protected function getStats(): array
    {
        $total = ContactMessage::query()->count();
        $unread = ContactMessage::unread()->count();
        $thisMonth = ContactMessage::query()->where('created_at', '>=', now()->startOfMonth())->count();

        return [
            Stat::make('Total', number_format($total))
                ->description('Messages reçus')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('primary'),

            Stat::make('Non lus', number_format($unread))
                ->description('En attente de réponse')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Reçus ce mois', number_format($thisMonth))
                ->description('Depuis le 1er')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('info'),
        ];
    }
}
