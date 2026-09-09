<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->circular()
                    ->width(44)
                    ->height(44)
                    ->placeholder('—'),

                TextColumn::make('name')
                    ->label('Auteur')
                    ->searchable()
                    ->description(fn ($record): string => collect([$record->role, $record->company])->filter()->implode(' · '))
                    ->wrap(),

                TextColumn::make('content')
                    ->label('Témoignage')
                    ->limit(80)
                    ->wrap(),

                IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                    ->label('Visibilité'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('sort_order');
    }
}
