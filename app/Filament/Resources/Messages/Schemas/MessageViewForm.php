<?php

namespace App\Filament\Resources\Messages\Schemas;

use App\Models\ContactMessage;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
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
                            ->formatStateUsing(fn (mixed $state): string => $state
                                ? Carbon::parse($state)->translatedFormat('d/m/Y à H:i')
                                : 'Non lu')
                            ->disabled(),
                    ]),

                Section::make('Message')
                    ->schema([
                        Textarea::make('message')
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Section::make('Suivi commercial')
                    ->description('Suivez la demande jusqu’à sa qualification ou sa clôture.')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->options(ContactMessage::statusOptions())
                            ->required(),

                        Select::make('priority')
                            ->label('Priorité')
                            ->options(ContactMessage::priorityOptions())
                            ->required(),

                        DateTimePicker::make('follow_up_at')
                            ->label('Relance prévue')
                            ->timezone(config('app.timezone')),

                        Textarea::make('internal_notes')
                            ->label('Notes internes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
