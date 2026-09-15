<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactPipelineWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Pipeline commercial';

    protected ?string $description = 'Demandes entrantes et prochaines relances.';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 6,
    ];

    protected function getStats(): array
    {
        return [
            Stat::make('À qualifier', number_format(ContactMessage::query()->whereIn('status', [
                ContactMessage::STATUS_NEW,
                ContactMessage::STATUS_QUALIFYING,
            ])->count()))
                ->description('Nouvelles demandes et qualification en cours')
                ->color('warning'),

            Stat::make('Propositions', number_format(ContactMessage::query()->where('status', ContactMessage::STATUS_PROPOSAL)->count()))
                ->description('Propositions en attente de décision')
                ->color('info'),

            Stat::make('Relances dues', number_format(ContactMessage::query()
                ->whereNotIn('status', [ContactMessage::STATUS_WON, ContactMessage::STATUS_LOST])
                ->whereNotNull('follow_up_at')
                ->where('follow_up_at', '<=', now())
                ->count()))
                ->description('À traiter maintenant')
                ->color('danger'),
        ];
    }
}
