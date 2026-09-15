<?php

namespace App\Filament\Resources\Messages\Tables;

use App\Models\AdminActivityLog;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('subject')
                    ->label('Sujet')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('budget')
                    ->label('Budget')
                    ->formatStateUsing(fn (?string $state, ContactMessage $record): string => $record->budgetLabel() ?? '—')
                    ->icon('heroicon-o-banknotes'),

                TextColumn::make('read_at')
                    ->label('Lu le')
                    ->formatStateUsing(fn ($state): string => $state ? $state->translatedFormat('d/m/Y H:i') : 'Non lu')
                    ->color(fn ($state): string => $state ? 'gray' : 'warning')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Pipeline')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ContactMessage::statusOptions()[$state] ?? (string) $state)
                    ->colors([
                        'gray' => ContactMessage::STATUS_NEW,
                        'warning' => ContactMessage::STATUS_QUALIFYING,
                        'info' => ContactMessage::STATUS_PROPOSAL,
                        'success' => ContactMessage::STATUS_WON,
                        'danger' => ContactMessage::STATUS_LOST,
                    ])
                    ->sortable(),

                TextColumn::make('priority')
                    ->label('Priorité')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ContactMessage::priorityOptions()[$state] ?? (string) $state)
                    ->colors([
                        'gray' => ContactMessage::PRIORITY_LOW,
                        'info' => ContactMessage::PRIORITY_NORMAL,
                        'danger' => ContactMessage::PRIORITY_HIGH,
                    ])
                    ->sortable(),

                TextColumn::make('follow_up_at')
                    ->label('Relance')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('unread')
                    ->label('Non lus uniquement')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at')),

                SelectFilter::make('status')
                    ->label('Pipeline')
                    ->options(ContactMessage::statusOptions()),

                SelectFilter::make('priority')
                    ->label('Priorité')
                    ->options(ContactMessage::priorityOptions()),
            ])
            ->recordActions([
                ViewAction::make()->label('Lire'),
                Action::make('updatePipeline')
                    ->label('Suivi commercial')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->color('info')
                    ->fillForm(fn (ContactMessage $record): array => [
                        'status' => $record->status,
                        'priority' => $record->priority,
                        'follow_up_at' => $record->follow_up_at,
                        'internal_notes' => $record->internal_notes,
                    ])
                    ->form([
                        Select::make('status')
                            ->label('Statut')
                            ->options(ContactMessage::statusOptions())
                            ->required(),
                        Select::make('priority')
                            ->label('Priorité')
                            ->options(ContactMessage::priorityOptions())
                            ->required(),
                        DateTimePicker::make('follow_up_at')
                            ->label('Relance prévue')
                            ->timezone(config('app.timezone')),
                        Textarea::make('internal_notes')
                            ->label('Notes internes')
                            ->rows(4),
                    ])
                    ->action(function (ContactMessage $record, array $data): void {
                        $previousStatus = $record->status;
                        $record->update($data);

                        AdminActivityLog::record(
                            'messages.pipeline_update',
                            "Demande de {$record->name} : {$previousStatus} → {$record->status}.",
                            $record,
                        );
                    }),
                Action::make('markAsRead')
                    ->label('Marquer comme lu')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (ContactMessage $record): bool => ! $record->isRead())
                    ->action(fn (ContactMessage $record) => $record->markAsRead()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
