<?php

namespace App\Filament\Resources\Skills\Schemas;

use App\Enums\SkillLevel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SkillForm
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

                TextInput::make('icon')
                    ->label('Icône')
                    ->maxLength(255)
                    ->placeholder('Emoji ou URL officielle')
                    ->helperText('Emoji (ex : 🐘) ou icône officielle (ex : https://cdn.simpleicons.org/laravel) affichée sur le site public.'),

                Select::make('level')
                    ->options(SkillLevel::options())
                    ->required(),

                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
