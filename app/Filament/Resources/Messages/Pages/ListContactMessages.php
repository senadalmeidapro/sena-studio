<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\ContactMessageResource;
use App\Filament\Widgets\ContactMessageStatsWidget;
use App\Filament\Widgets\MessagesVolumeChartWidget;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportCsv')
                ->label('Exporter en CSV')
                ->color('gray')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $messages = ContactMessage::query()
                        ->orderByDesc('created_at')
                        ->get();

                    $handle = fopen('php://temp', 'r+');
                    fputcsv($handle, [
                        'Date', 'Nom', 'Email', 'Téléphone', 'Société', 'Sujet', 'Budget', 'Lu le', 'Message',
                    ], separator: ';');

                    foreach ($messages as $message) {
                        fputcsv($handle, [
                            $message->created_at?->toDateTimeString(),
                            $message->name,
                            $message->email,
                            $message->phone,
                            $message->company,
                            $message->subject,
                            $message->budgetLabel() ?? '',
                            $message->read_at?->toDateTimeString(),
                            $message->message,
                        ], separator: ';');
                    }

                    rewind($handle);
                    $csv = stream_get_contents($handle);
                    fclose($handle);

                    return response()->streamDownload(
                        function () use ($csv) {
                            echo "\xEF\xBB\xBF".$csv;
                        },
                        'messages-'.now()->format('Y-m-d').'.csv',
                        ['Content-Type' => 'text/csv; charset=UTF-8'],
                    );
                }),

            Action::make('markAllRead')
                ->label('Tout marquer comme lu')
                ->color('gray')
                ->icon('heroicon-o-check-circle')
                ->action(function () {
                    ContactMessage::query()->whereNull('read_at')->update(['read_at' => now()]);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContactMessageStatsWidget::class,
            MessagesVolumeChartWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }
}
