<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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

                TextColumn::make('complexity')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->colors([
                        'gray' => 'simple',
                        'warning' => 'medium',
                        'danger' => 'complex',
                    ])
                    ->sortable(),

                TextColumn::make('stack.name')
                    ->label('Stack')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->money('USD')
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

                SelectFilter::make('complexity')
                    ->options(ProjectComplexity::options()),

                SelectFilter::make('visibility')
                    ->label('Visibility')
                    ->options(ProjectVisibility::options()),

                SelectFilter::make('stack')
                    ->relationship('stack', 'name'),

                SelectFilter::make('infra')
                    ->relationship('infra', 'name'),

                Filter::make('price_range')
                    ->label('Price Range')
                    ->form([
                        TextInput::make('min_price')
                            ->label('Minimum Price')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('max_price')
                            ->label('Maximum Price')
                            ->numeric()
                            ->prefix('$'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_price'] ?? null,
                                fn (Builder $query, $min_price) => $query->where('price', '>=', $min_price)
                            )
                            ->when(
                                $data['max_price'] ?? null,
                                fn (Builder $query, $max_price) => $query->where('price', '<=', $max_price)
                            );
                    }),

                Filter::make('date_range')
                    ->label('Created Date Range')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From'),
                        DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
