<?php

namespace App\Filament\Resources\Cvs\Tables;

use App\Enums\CvStatus;
use App\Enums\CvTemplate;
use App\Models\Cv;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CvsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('version_label')
                    ->label('Version')
                    ->placeholder('—')
                    ->icon(function ($record): ?string {
                        return $record->is_primary ? 'heroicon-m-star' : null;
                    })
                    ->iconColor(fn ($record): ?string => $record->is_primary ? 'warning' : null)
                    ->description(fn ($record): string => $record->title)
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('headline')
                    ->label('Poste')
                    ->placeholder('—')
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('template')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Cv $record): string => $record->status === CvStatus::Published ? 'success' : 'gray'),

                IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Principale')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('template')
                    ->options(CvTemplate::options()),

                SelectFilter::make('status')
                    ->options(CvStatus::options()),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
