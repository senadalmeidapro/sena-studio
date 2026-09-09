<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publication')
                    ->description('Statut, dates et rattachements de l’article.')
                    ->columns(3)
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->options([
                                Post::STATUS_DRAFT => 'Brouillon',
                                Post::STATUS_PUBLISHED => 'Publié',
                            ])
                            ->default(Post::STATUS_DRAFT)
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Publié le')
                            ->helperText('Laisser vide : défini automatiquement à la première publication.')
                            ->timezone(config('app.timezone')),

                        Select::make('user_id')
                            ->label('Auteur')
                            ->relationship(name: 'author', titleAttribute: 'name')
                            ->default(fn (): ?int => auth()->id())
                            ->searchable()
                            ->preload(),

                        CheckboxList::make('categories')
                            ->label('Catégories')
                            ->relationship(name: 'categories', titleAttribute: 'name')
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Contenu')
                    ->description('Le corps de l’article et son image de couverture.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->afterStateUpdated(function ($state, $set): void {
                                if (blank($state)) {
                                    return;
                                }

                                $slug = Str::slug($state);

                                if (blank(request()->route('record'))) {
                                    $set('slug', $slug);
                                }
                            })
                            ->live(onBlur: true),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('excerpt')
                            ->label('Extrait')
                            ->helperText('Résumé affiché dans la liste des articles et la page SEO.')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Contenu')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        FileUpload::make('cover_image')
                            ->label('Image de couverture')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('posts')
                            ->optimize('webp')
                            ->maxSize(4096)
                            ->columnSpanFull(),
                    ]),

                Section::make('Référencement')
                    ->description('Métadonnées de partage et de référencement naturel.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Titre SEO')
                            ->placeholder('≤ 60 caractères conseillé')
                            ->maxLength(255),

                        Textarea::make('seo_description')
                            ->label('Description SEO')
                            ->placeholder('≤ 155 caractères conseillé')
                            ->rows(3)
                            ->maxLength(300)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
