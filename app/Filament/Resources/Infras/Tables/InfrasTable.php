<?php

namespace App\Filament\Resources\Infras\Tables;

use App\Enums\InfraEnvironment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InfrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('environment')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->colors([
                        'gray' => 'development',
                        'warning' => 'staging',
                        'success' => 'production',
                    ])
                    ->sortable(),

                TextColumn::make('cpu_cores')
                    ->label('CPU Cores')
                    ->sortable(),

                TextColumn::make('memory_mb')
                    ->label('Memory (MB)')
                    ->sortable(),

                TextColumn::make('storage_gb')
                    ->label('Storage (GB)')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('environment')
                    ->options(InfraEnvironment::options()),

                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),

                Filter::make('resources')
                    ->label('Resource Requirements')
                    ->form([
                        TextInput::make('min_cpu')
                            ->label('Minimum CPU Cores')
                            ->numeric(),
                        TextInput::make('min_memory')
                            ->label('Minimum Memory (MB)')
                            ->numeric(),
                        TextInput::make('min_storage')
                            ->label('Minimum Storage (GB)')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_cpu'] ?? null,
                                fn (Builder $query, $cpu) => $query->where('cpu_cores', '>=', $cpu)
                            )
                            ->when(
                                $data['min_memory'] ?? null,
                                fn (Builder $query, $mem) => $query->where('memory_mb', '>=', $mem)
                            )
                            ->when(
                                $data['min_storage'] ?? null,
                                fn (Builder $query, $storage) => $query->where('storage_gb', '>=', $storage)
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
