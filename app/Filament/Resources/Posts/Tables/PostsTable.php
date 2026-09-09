<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('')
                    ->url(fn (Post $record): ?string => $record->cover_image ? asset($record->cover_image) : null)
                    ->placeholder('—')
                    ->circular()
                    ->width(56)
                    ->height(56),

                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->description(fn (Post $record): ?string => $record->excerpt ? mb_strimwidth($record->excerpt, 0, 90, '…') : null)
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (Post $record): string => $record->status === Post::STATUS_PUBLISHED ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state): string => $state === Post::STATUS_PUBLISHED ? 'Publié' : 'Brouillon'),

                TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Auteur')
                    ->placeholder('—')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        Post::STATUS_DRAFT => 'Brouillon',
                        Post::STATUS_PUBLISHED => 'Publié',
                    ]),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('Aperçu')
                    ->icon('heroicon-m-eye')
                    ->visible(fn (Post $record): bool => $record->isPublished())
                    ->url(fn (Post $record): string => route('posts.show', $record->slug))
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }
}
