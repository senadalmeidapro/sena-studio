<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Models\Client;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static UnitEnum|string|null $navigationGroup = 'Clients';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([TextInput::make('name')->required()->maxLength(255), TextInput::make('company')->maxLength(255), TextInput::make('email')->email()->maxLength(255), TextInput::make('phone')->maxLength(40), TextInput::make('country')->maxLength(120), TextInput::make('source')->maxLength(255), Textarea::make('notes')->columnSpanFull()]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('name')->searchable()->sortable(), TextColumn::make('company')->searchable()->placeholder('—'), TextColumn::make('email')->searchable()->placeholder('—'), TextColumn::make('engagements_count')->counts('engagements')->label('Engagements')])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListClients::route('/'), 'create' => CreateClient::route('/create'), 'edit' => EditClient::route('/{record}/edit')];
    }
}
