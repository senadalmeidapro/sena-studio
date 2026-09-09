<?php

namespace App\Filament\Resources\AuditLogs;

use App\Filament\Resources\AuditLogs\Pages\ListAuditLogs;
use App\Models\AdminActivityLog;
use App\Support\Activity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AuditLogResource extends Resource
{
    protected static ?string $model = AdminActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'action';

    protected static UnitEnum|string|null $navigationGroup = 'Système';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Événement';

    protected static ?string $pluralModelLabel = 'Journal d’activité';

    protected static bool $isGloballySearchable = false;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        $actions = AdminActivityLog::query()->distinct()->pluck('action')->map(fn (string $a): string => ucfirst(str_replace('.', ' · ', $a)))->all();

        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->width(140),

                TextColumn::make('action')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'delete') => 'danger',
                        str_contains($state, 'create') => 'success',
                        str_contains($state, 'update') => 'info',
                        str_contains($state, 'login') => 'gray',
                        default => 'warning',
                    })
                    ->icon(fn (string $state): string => Activity::icon($state))
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('.', ' · ', $state))),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('auditable_type')
                    ->label('Cible')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '—')
                    ->toggleable(),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->options(array_combine(
                        AdminActivityLog::query()->distinct()->pluck('action')->all(),
                        $actions,
                    )),

                SelectFilter::make('period')
                    ->label('Période')
                    ->options([
                        '24h' => '24 dernières heures',
                        '7d' => '7 derniers jours',
                        '30d' => '30 derniers jours',
                        '90d' => '90 derniers jours',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            '24h' => $query->where('created_at', '>=', now()->subDay()),
                            '7d' => $query->where('created_at', '>=', now()->subDays(7)),
                            '30d' => $query->where('created_at', '>=', now()->subDays(30)),
                            '90d' => $query->where('created_at', '>=', now()->subDays(90)),
                            default => $query,
                        };
                    }),

                TernaryFilter::make('has_details')
                    ->label('Avec description')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('description'),
                        false: fn (Builder $query): Builder => $query->whereNull('description'),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuditLogs::route('/'),
        ];
    }
}
