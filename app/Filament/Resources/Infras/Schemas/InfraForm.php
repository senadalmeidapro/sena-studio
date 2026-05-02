<?php

namespace App\Filament\Resources\Infras\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InfraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description'),

                TextInput::make('docker_image')
                    ->maxLength(255),

                Textarea::make('kubernetes_config'),

                Textarea::make('helm_chart'),

                TextInput::make('cpu_cores')
                    ->numeric()
                    ->minValue(1)
                    ->default(1),

                TextInput::make('memory_mb')
                    ->numeric()
                    ->minValue(512)
                    ->default(512),

                TextInput::make('storage_gb')
                    ->numeric()
                    ->minValue(1)
                    ->default(10),

                Select::make('environment')
                    ->options([
                        'development' => 'Development',
                        'staging' => 'Staging',
                        'production' => 'Production',
                    ])
                    ->required(),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
