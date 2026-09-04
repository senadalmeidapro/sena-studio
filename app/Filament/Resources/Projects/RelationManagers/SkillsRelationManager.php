<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkillsRelationManager extends RelationManager
{
    protected static string $relationship = 'skills';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('proficiency')
                ->options([
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                    'research' => 'Research',
                ])
                ->default('secondary')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('level')
                    ->badge(),

                TextColumn::make('pivot.proficiency')
                    ->label('Proficiency for this project')
                    ->badge(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('proficiency')
                            ->options([
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                                'research' => 'Research',
                            ])
                            ->default('secondary')
                            ->required(),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ]);
    }
}
