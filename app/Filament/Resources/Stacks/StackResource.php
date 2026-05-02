<?php

namespace App\Filament\Resources\Stacks;

use App\Filament\Resources\Stacks\Pages\CreateStack;
use App\Filament\Resources\Stacks\Pages\EditStack;
use App\Filament\Resources\Stacks\Pages\ListStacks;
use App\Filament\Resources\Stacks\Schemas\StackForm;
use App\Filament\Resources\Stacks\Tables\StacksTable;
use App\Models\Stack;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StackResource extends Resource
{
    protected static ?string $model = Stack::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCubeTransparent;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return StackForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StacksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStacks::route('/'),
            'create' => CreateStack::route('/create'),
            'edit' => EditStack::route('/{record}/edit'),
        ];
    }
}
