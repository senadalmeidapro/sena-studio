<?php

namespace App\Filament\Resources\Invoices;

use App\Enums\Currency;
use App\Enums\InvoiceStatus;
use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Models\Invoice;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'number';

    protected static UnitEnum|string|null $navigationGroup = 'Clients';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([Select::make('engagement_id')->relationship('engagement', 'title')->searchable()->preload()->required(), TextInput::make('number')->required()->unique(ignoreRecord: true)->maxLength(255), TextInput::make('amount')->numeric()->minValue(0)->required()->helperText('Integer minor units: EUR cents; XOF whole units.'), Select::make('currency')->options(Currency::options())->required()->default('EUR'), DatePicker::make('issued_at'), DatePicker::make('due_at'), DatePicker::make('paid_at'), Select::make('status')->options(InvoiceStatus::options())->required()->default('draft')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('number')->searchable(), TextColumn::make('engagement.title')->label('Engagement')->searchable(), TextColumn::make('amount')->numeric(), TextColumn::make('currency')->formatStateUsing(fn ($state): string => $state?->value ?? ''), TextColumn::make('due_at')->date(), TextColumn::make('status')->badge()->formatStateUsing(fn ($state): string => $state?->label() ?? '')])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListInvoices::route('/'), 'create' => CreateInvoice::route('/create'), 'edit' => EditInvoice::route('/{record}/edit')];
    }
}
