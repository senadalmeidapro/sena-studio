<?php

namespace App\Filament\Resources\Messages\Tables;

use App\Actions\ConvertContactMessageToClient;
use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                        $record->update($data);
                    }),
                Action::make('convertToClient')
                    ->label('Convertir en client + engagement')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->visible(fn (ContactMessage $record): bool => $record->client_id === null)
                    ->fillForm(fn (ContactMessage $record): array => [
                        'name' => $record->name,
                        'email' => $record->email,
                        'company' => $record->company,
                        'title' => $record->subject ?: 'Premier engagement',
                        'scope' => $record->message,
                        'budget_reference' => $record->budgetLabel(),
                        'pricing_model' => EngagementPricingModel::Fixed->value,
                        'currency' => Currency::EUR->value,
                    ])
                    ->form([
                        TextInput::make('name')->label('Nom')->required()->maxLength(255),
                        TextInput::make('email')->label('Email')->email()->maxLength(255),
                        TextInput::make('company')->label('Entreprise')->maxLength(255),
                        TextInput::make('title')->label('Engagement')->required()->maxLength(255),
                        Textarea::make('scope')->label('Périmètre')->rows(4)->required(),
                        TextInput::make('budget_reference')->label('Budget indiqué')->disabled()->dehydrated(false),
                        Select::make('pricing_model')->label('Modèle tarifaire')->options(EngagementPricingModel::options())->required(),
                        TextInput::make('amount')->label('Montant en unités mineures')->numeric()->minValue(0)->helperText('EUR en centimes; XOF en unités entières.'),
                        Select::make('currency')->label('Devise')->options(Currency::options())->required(),
                    ])
                    ->action(function (ContactMessage $record, array $data): void {
                        app(ConvertContactMessageToClient::class)->handle($record, $data);
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
