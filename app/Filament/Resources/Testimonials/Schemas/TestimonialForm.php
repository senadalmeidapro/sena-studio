<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Services\CloudinaryService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Témoignage')
                    ->description('Contenu et auteur du témoignage.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(120)
                            ->columnSpan(1),

                        TextInput::make('role')
                            ->label('Rôle')
                            ->placeholder('Ex : Directrice produit')
                            ->maxLength(120)
                            ->columnSpan(1),

                        TextInput::make('company')
                            ->label('Société')
                            ->maxLength(120)
                            ->columnSpan(1),

                        app(CloudinaryService::class)->fileUpload('avatar')
                            ->label('Avatar')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('testimonials')
                            ->maxSize(2048)
                            ->columnSpan(1),

                        Toggle::make('is_visible')
                            ->label('Visible sur le site')
                            ->default(true)
                            ->columnSpan(1),

                        TextInput::make('sort_order')
                            ->label('Ordre')
                            ->numeric()
                            ->default(0)
                            ->helperText('Les témoignages sont affichés dans l’ordre croissant.')
                            ->columnSpan(1),

                        Textarea::make('content')
                            ->label('Témoignage')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
