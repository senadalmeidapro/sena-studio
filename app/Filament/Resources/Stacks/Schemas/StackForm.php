<?php

namespace App\Filament\Resources\Stacks\Schemas;

use App\Enums\StackItemCategory;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description'),

                Toggle::make('is_active')
                    ->default(true),

                Repeater::make('stack_items')
                    ->relationship()
                    ->schema([
                        Select::make('category')
                            ->options(StackItemCategory::options())
                            ->required(),

                        TextInput::make('value')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('version')
                            ->maxLength(50),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
