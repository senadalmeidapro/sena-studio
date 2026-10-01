<?php

namespace App\Filament\Resources\Deliverables;

use App\Filament\Resources\Deliverables\Pages\CreateDeliverable;
use App\Filament\Resources\Deliverables\Pages\EditDeliverable;
use App\Filament\Resources\Deliverables\Pages\ListDeliverables;
use App\Models\Deliverable;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class DeliverableResource extends Resource
{
    protected static ?string $model = Deliverable::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'title';

    protected static UnitEnum|string|null $navigationGroup = 'Clients';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([Select::make('engagement_id')->relationship('engagement', 'title')->searchable()->preload()->required(), TextInput::make('title')->required()->maxLength(255), DatePicker::make('due_at'), DatePicker::make('done_at')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('title')->searchable(), TextColumn::make('engagement.title')->label('Engagement')->searchable(), TextColumn::make('due_at')->date(), TextColumn::make('done_at')->date()->placeholder('Open')])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListDeliverables::route('/'), 'create' => CreateDeliverable::route('/create'), 'edit' => EditDeliverable::route('/{record}/edit')];
    }
}
