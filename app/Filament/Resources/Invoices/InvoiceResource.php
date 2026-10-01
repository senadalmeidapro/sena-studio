<?php

namespace App\Filament\Resources\Invoices;

use App\Enums\Currency;
use App\Enums\InvoiceStatus;
use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Models\Invoice;
use App\Support\InvoiceNumberGenerator;
use App\Support\MoneyFormatter;
use BackedEnum;
use Filament\Actions\Action;
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
        return $schema->components([Select::make('engagement_id')->relationship('engagement', 'title')->searchable()->preload()->required(), TextInput::make('number')->default(fn (): string => app(InvoiceNumberGenerator::class)->next())->unique(ignoreRecord: true)->maxLength(255), TextInput::make('amount')->numeric()->minValue(0)->required()->helperText('Integer minor units: EUR cents; XOF whole units.'), Select::make('currency')->options(Currency::options())->required()->default('EUR'), DatePicker::make('issued_at'), DatePicker::make('due_at'), DatePicker::make('paid_at'), Select::make('status')->options(InvoiceStatus::options())->required()->default('draft')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('number')->searchable(), TextColumn::make('engagement.title')->label('Engagement')->searchable(), TextColumn::make('amount')->label('Amount')->formatStateUsing(fn ($state, Invoice $record): string => app(MoneyFormatter::class)->format((int) $state, $record->currency)), TextColumn::make('due_at')->date(), TextColumn::make('status')->badge()->formatStateUsing(fn ($state): string => $state?->label() ?? '')])->recordActions([
            EditAction::make(),
            Action::make('downloadInvoice')->label('Download invoice PDF')->icon('heroicon-o-document-arrow-down')->url(fn (Invoice $record): string => route('admin.billing.invoices.pdf', $record)),
            Action::make('markAsPaid')
                ->label('Mark as paid')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Invoice $record): bool => $record->status !== InvoiceStatus::Paid)
                ->requiresConfirmation()
                ->action(fn (Invoice $record) => $record->update([
                    'status' => InvoiceStatus::Paid,
                    'paid_at' => today(),
                ])),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => ListInvoices::route('/'), 'create' => CreateInvoice::route('/create'), 'edit' => EditInvoice::route('/{record}/edit')];
    }
}
