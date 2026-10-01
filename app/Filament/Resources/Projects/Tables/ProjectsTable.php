<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\URL;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image')
                    ->circular(),

                IconColumn::make('featured')
                    ->label('À la une')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->colors([
                        'gray' => 'development',
                        'warning' => 'testing',
                        'success' => 'production',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->sortable(),

                TextColumn::make('started_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ended_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProjectStatus::options()),

                SelectFilter::make('type')
                    ->options(ProjectType::options()),

                SelectFilter::make('visibility')
                    ->label('Visibility')
                    ->options(ProjectVisibility::options()),

                TernaryFilter::make('featured')
                    ->label('Projets mis en avant'),

            ])
            ->recordActions([
                Action::make('protectedShareLink')
                    ->label('Signed share link')
                    ->icon('heroicon-o-link')
                    ->visible(fn ($record): bool => $record->visibility === ProjectVisibility::Protected)
                    ->url(fn ($record): string => URL::signedRoute(
                        'projects.protected',
                        ['locale' => app()->getLocale(), 'project' => $record->slug],
                    ))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
