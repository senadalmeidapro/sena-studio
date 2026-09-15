<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use App\Services\CloudinaryService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
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

                Section::make('Positionnement')
                    ->description('Présente le contexte technique du projet sans inventer de métriques.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description courte')
                            ->rows(4)
                            ->columnSpanFull(),

                        TextInput::make('role')
                            ->label('Rôle')
                            ->placeholder('Ex. Conception backend et architecture API')
                            ->maxLength(255),

                        Toggle::make('featured')
                            ->label('Projet mis en avant')
                            ->default(false),

                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Étude de cas')
                    ->description('Ces champs structurent la réflexion d’ingénierie présentée publiquement.')
                    ->schema([
                        Textarea::make('problem')
                            ->label('Problème ou contexte')
                            ->rows(4),

                        Textarea::make('architecture')
                            ->label('Architecture')
                            ->rows(4),

                        Textarea::make('technical_decisions')
                            ->label('Décisions techniques')
                            ->rows(4),

                        Textarea::make('result')
                            ->label('Résultat ou apprentissage')
                            ->rows(4),
                    ])
                    ->columns(2)
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

                app(CloudinaryService::class)->fileUpload('image')
                    ->label('Couverture du projet')
                    ->image()
                    ->imageEditor()
                    ->directory('sena-studio/projects')
                    ->maxSize(10240)
                    ->helperText('Aperçu principal / couverture du projet.'),

                Repeater::make('projectImages')
                    ->relationship()
                    ->label('Aperçus supplémentaires')
                    ->schema([
                        app(CloudinaryService::class)->fileUpload('path')
                            ->label('Aperçu')
                            ->image()
                            ->imageEditor()
                            ->directory('sena-studio/gallery')
                            ->maxSize(10240)
                            ->required(),
                        TextInput::make('caption')
                            ->maxLength(160),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->orderable('sort_order')
                    ->collapsible()
                    ->columnSpanFull(),

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
                    ->columnSpanFull()
                    ->helperText('Proficiency per skill is set in the Skills tab below after saving.'),

                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
