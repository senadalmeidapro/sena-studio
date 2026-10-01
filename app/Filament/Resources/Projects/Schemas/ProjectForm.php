<?php

namespace App\Filament\Resources\Projects\Schemas;

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
                    ->description('Un bon récit présente votre rôle, le problème, les décisions techniques et un résultat vérifiable. N’ajoutez aucun fait confidentiel ou non confirmé. Les informations client sont facultatives pour préserver l’anonymat.')
                    ->schema([
                        TextInput::make('role')
                            ->label('Rôle')
                            ->maxLength(255),

                        TextInput::make('client_context')
                            ->label('Contexte client (facultatif)')
                            ->maxLength(255),

                        Textarea::make('problem')
                            ->label('Contexte et problème')
                            ->rows(4),

                        Textarea::make('constraints')
                            ->label('Contraintes')
                            ->placeholder('Conformité, paiements, connectivité, délais…')
                            ->rows(3),

                        Textarea::make('architecture')
                            ->label('Architecture')
                            ->rows(4),

                        Textarea::make('technical_decisions')
                            ->label('Décisions techniques')
                            ->rows(4),

                        Textarea::make('result')
                            ->label('Résultat ou apprentissage')
                            ->rows(4),

                        Select::make('outcome_type')
                            ->label('Type de résultat')
                            ->options([
                                'delivered' => __('project.outcome_delivered'),
                                'ongoing' => __('project.outcome_ongoing'),
                                'internal' => __('project.outcome_internal'),
                            ])
                            ->rules(['nullable', 'in:delivered,ongoing,internal'])
                            ->nullable(),

                        TextInput::make('result_metric')
                            ->label('Métrique principale')
                            ->maxLength(255),

                        Select::make('testimonial_id')
                            ->label('Témoignage lié')
                            ->relationship('testimonial', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Textarea::make('deployment')
                    ->label('Déploiement')
                    ->rows(3)
                    ->maxLength(2000)
                    ->columnSpanFull(),

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

                Select::make('visibility')
                    ->options(ProjectVisibility::options())
                    ->default(ProjectVisibility::Public->value)
                    ->required(),

                DatePicker::make('started_at'),

                DatePicker::make('ended_at'),

                Select::make('skills')
                    ->relationship('skills', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->helperText('Skills shown on the public project page.'),

                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
