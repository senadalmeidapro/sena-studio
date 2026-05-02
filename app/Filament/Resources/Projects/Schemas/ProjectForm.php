<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->columnSpanFull(),

                TextInput::make('version')
                    ->default('1.0.0')
                    ->maxLength(50),

                TextInput::make('price')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                TextInput::make('url')
                    ->url()
                    ->maxLength(255),

                TextInput::make('repository_url')
                    ->url()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->image()
                    ->directory('projects')
                    ->preserveFilenames(),

                Select::make('status')
                    ->options(ProjectStatus::options())
                    ->default(ProjectStatus::Development->value)
                    ->required(),

                Select::make('type')
                    ->options(ProjectType::options())
                    ->default(ProjectType::Web->value)
                    ->required(),

                Select::make('complexity')
                    ->options(ProjectComplexity::options())
                    ->default(ProjectComplexity::Simple->value)
                    ->required(),

                Select::make('visibility')
                    ->options(ProjectVisibility::options())
                    ->default(ProjectVisibility::Public->value)
                    ->required(),

                DatePicker::make('started_at'),

                DatePicker::make('ended_at'),

                Select::make('stack_id')
                    ->relationship('stack', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('infra_id')
                    ->relationship('infra', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('skills')
                    ->relationship('skills', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
