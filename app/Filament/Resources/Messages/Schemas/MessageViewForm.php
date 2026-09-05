<?php

namespace App\Filament\Resources\Messages\Schemas;

use App\Models\ContactMessage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class MessageViewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Expéditeur')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->placeholder('—')
                            ->disabled(),
                        TextInput::make('company')
                            ->label('Société / organisation')
                            ->placeholder('—')
                            ->disabled(),
                        TextInput::make('subject')
                            ->label('Sujet')
                            ->columnSpanFull()
                            ->disabled(),
                        TextInput::make('budget')
                            ->label('Budget estimé')
                            ->formatStateUsing(fn (?string $state, ?ContactMessage $record): string => $record?->budgetLabel() ?? '—')
                            ->disabled(),
                        TextInput::make('read_at')
                            ->label('Lu le')
                            ->formatStateUsing(fn (?Carbon $state): string => $state?->translatedFormat('d/m/Y à H:i') ?? 'Non lu')
                            ->disabled(),
                    ]),

                Section::make('Message')
                    ->schema([
                        Textarea::make('message')
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
