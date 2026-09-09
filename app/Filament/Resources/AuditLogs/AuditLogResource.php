<?php

namespace App\Filament\Resources\AuditLogs;

use App\Filament\Resources\AuditLogs\Pages\ListAuditLogs;
use App\Models\AdminActivityLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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
                    ->color('gray')
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
