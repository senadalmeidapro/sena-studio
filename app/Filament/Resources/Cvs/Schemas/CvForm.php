<?php

namespace App\Filament\Resources\Cvs\Schemas;

use App\Enums\CvLanguageLevel;
use App\Enums\CvSkillLevel;
use App\Enums\CvStatus;
use App\Enums\CvTemplate;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CvForm
{
    public static function configure(Schema $schema): Schema
    {
        $section = fn (string $title, string $subtitle, array $fields): Section => Section::make($title)
            ->description($subtitle)
            ->columns(2)
            ->schema($fields);

        return $schema
            ->components([
                Section::make('Version')
                    ->description('Identité et positionnement de cette version du CV.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre du document')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('version_label')
                            ->label('Version / modèle')
                            ->placeholder('Ex : V1 · Développeur Fullstack')
                            ->helperText('Le slug sera généré automatiquement depuis cette valeur si vide.')
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->dehydrated()
                            ->maxLength(255),

                        Select::make('template')
                            ->label('Modèle de rendu')
                            ->options(CvTemplate::options())
                            ->default(CvTemplate::Classique)
                            ->required(),

                        Select::make('status')
                            ->label('Statut')
                            ->options(CvStatus::options())
                            ->default(CvStatus::Draft)
                            ->required(),

                        Toggle::make('is_primary')
                            ->label('Version principale')
                            ->helperText('Cochez pour en faire la version mise en avant.'),

                        Select::make('accent_color')
                            ->label('Couleur d’accent')
                            ->options([
                                '#059669' => 'Émeraude',
                                '#7c3aed' => 'Violet',
                                '#2563eb' => 'Bleu',
                                '#d97706' => 'Ambre',
                                '#e11d48' => 'Rose',
                                '#334155' => 'Ardoise',
                            ])
                            ->default('#059669'),
                    ]),

                $section('Accroche', 'Votre situation professionnelle en quelques lignes.', [
                    TextInput::make('headline')
                        ->label('Titre / poste visé')
                        ->maxLength(255)
                        ->columnSpan(2),

                    Textarea::make('summary')
                        ->label('Résumé')
                        ->rows(4)
                        ->columnSpan(2),
                ]),

                $section('Coordonnées', 'Les informations de contact affichées en en-tête.', [
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->label('Téléphone')
                        ->maxLength(255),
                    TextInput::make('location')
                        ->label('Localisation')
                        ->maxLength(255),
                    TextInput::make('website')
                        ->label('Site web')
                        ->url()
                        ->maxLength(255),
                ]),

                Repeater::make('links')
                    ->label('Liens (portfolio, GitHub, LinkedIn…)')
                    ->columns(2)
                    ->default([])
                    ->schema([
                        TextInput::make('label')
                            ->label('Libellé')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->collapsible()
                    ->defaultItems(0)
                    ->columnSpanFull(),

                Tabs::make('content')
                    ->tabs([
                        Tab::make('Expériences')
                            ->schema([
                                Repeater::make('experience')
                                    ->label('Parcours professionnel')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(6)
                                    ->schema([
                                        TextInput::make('title')->label('Poste')
                                            ->required()
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        TextInput::make('subtitle')->label('Société')
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        DatePicker::make('period_start')->label('Début')
                                            ->columnSpan(1),
                                        DatePicker::make('period_end')->label('Fin')
                                            ->helperText('Laisser vide si en cours')
                                            ->columnSpan(1),
                                        Textarea::make('description')->label('Mission')
                                            ->rows(3)
                                            ->columnSpan(6),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Formations')
                            ->schema([
                                Repeater::make('education')
                                    ->label('Parcours d’études')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(6)
                                    ->schema([
                                        TextInput::make('title')->label('Diplôme')
                                            ->required()
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        TextInput::make('subtitle')->label('École / organisme')
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        DatePicker::make('period_start')->label('Début')
                                            ->columnSpan(1),
                                        DatePicker::make('period_end')->label('Fin')
                                            ->columnSpan(1),
                                        Textarea::make('description')->label('Détails')
                                            ->rows(3)
                                            ->columnSpan(6),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Compétences')
                            ->schema([
                                Repeater::make('skills')
                                    ->label('Compétences techniques')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('name')->label('Nom')
                                            ->required()
                                            ->maxLength(255),
                                        Select::make('level')->label('Niveau')
                                            ->options(CvSkillLevel::options()),
                                        Select::make('experience')->label('Expérience')
                                            ->options([
                                                '1-2 ans' => '1-2 ans',
                                                '2-4 ans' => '2-4 ans',
                                                '4-7 ans' => '4-7 ans',
                                                '7+ ans' => '7+ ans',
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Langues')
                            ->schema([
                                Repeater::make('languages')
                                    ->label('Langues parlées')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')->label('Langue')
                                            ->required()
                                            ->maxLength(100),
                                        Select::make('level')->label('Niveau')
                                            ->options(CvLanguageLevel::options()),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Certifications')
                            ->schema([
                                Repeater::make('certifications')
                                    ->label('Certifications, diplômes complémentaires')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('title')->label('Titre')
                                            ->required()
                                            ->columnSpan(1)
                                            ->maxLength(255),
                                        TextInput::make('subtitle')->label('Organisme')
                                            ->columnSpan(1)
                                            ->maxLength(255),
                                        TextInput::make('year')->label('Année')
                                            ->numeric()
                                            ->minValue(1990)
                                            ->maxValue(2100),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Centres d’intérêt')
                            ->schema([
                                Repeater::make('hobbies')
                                    ->label('Passions & activités')
                                    ->default([])
                                    ->defaultItems(0)
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('name')->label('Centre d’intérêt')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
