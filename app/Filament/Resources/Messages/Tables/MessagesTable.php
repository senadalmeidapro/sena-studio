<?php

namespace App\Filament\Resources\Messages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
            ])
            ->filters([
                Filter::make('unread')
                    ->label('Non lus uniquement')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at')),
            ])
            ->recordActions([
                ViewAction::make()->label('Lire'),
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
