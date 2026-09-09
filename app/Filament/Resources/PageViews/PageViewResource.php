<?php

namespace App\Filament\Resources\PageViews;

use App\Filament\Resources\PageViews\Pages\ListPageViews;
use App\Models\PageView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use UnitEnum;

class PageViewResource extends Resource
{
    protected static ?string $model = PageView::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

    protected static ?string $recordTitleAttribute = 'path';

    protected static UnitEnum|string|null $navigationGroup = 'Observabilité';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Visite';

    protected static ?string $pluralModelLabel = 'Trafic public';

    protected static bool $isGloballySearchable = false;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->width(140),

                TextColumn::make('path')
                    ->label('Page')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('locale')
                    ->label('Langue')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'en' ? 'info' : 'primary')
                    ->formatStateUsing(fn (?string $state): string => $state === 'en' ? 'EN' : 'FR'),

                TextColumn::make('referer')
                    ->label('Origine')
                    ->placeholder('—')
                    ->formatStateUsing(fn (?string $state): string => (string) Str::of((string) $state)->after('://')->before('/')->limit(40))
                    ->toggleable()
                    ->wrap(),

                IconColumn::make('is_bot')
                    ->label('Robot')
                    ->boolean()
                    ->trueIcon('heroicon-o-computer-desktop')
                    ->falseIcon('heroicon-o-user')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('period')
                    ->label('Période')
                    ->options([
                        '24h' => '24 dernières heures',
                        '7d' => '7 derniers jours',
                        '30d' => '30 derniers jours',
                    ])
                    ->default('30d')
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            '24h' => $query->where('created_at', '>=', now()->subDay()),
                            '7d' => $query->where('created_at', '>=', now()->subDays(7)),
                            '30d' => $query->where('created_at', '>=', now()->subDays(30)),
                            default => $query,
                        };
                    }),

                SelectFilter::make('bot')
                    ->label('Visiteur')
                    ->options([
                        'humans' => 'Humains uniquement',
                        'bots' => 'Robots uniquement',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'humans' => $query->where('is_bot', false),
                            'bots' => $query->where('is_bot', true),
                            default => $query,
                        };
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageViews::route('/'),
        ];
    }
}
