<?php

namespace App\Filament\Resources\Infras;

use App\Filament\Resources\Infras\Pages\CreateInfra;
use App\Filament\Resources\Infras\Pages\EditInfra;
use App\Filament\Resources\Infras\Pages\ListInfras;
use App\Filament\Resources\Infras\Schemas\InfraForm;
use App\Filament\Resources\Infras\Tables\InfrasTable;
use App\Models\Infra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfraResource extends Resource
{
    protected static ?string $model = Infra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return InfraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InfrasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInfras::route('/'),
            'create' => CreateInfra::route('/create'),
            'edit' => EditInfra::route('/{record}/edit'),
        ];
    }
}
