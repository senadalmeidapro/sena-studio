<?php

namespace App\Filament\Resources\Engagements;

use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Enums\EngagementStatus;
use App\Filament\Resources\Engagements\Pages\CreateEngagement;
use App\Filament\Resources\Engagements\Pages\EditEngagement;
use App\Filament\Resources\Engagements\Pages\ListEngagements;
use App\Models\Engagement;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class EngagementResource extends Resource
{
    protected static ?string $model = Engagement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $recordTitleAttribute = 'title';

    protected static UnitEnum|string|null $navigationGroup = 'Clients';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([Select::make('client_id')->relationship('client', 'name')->searchable()->preload()->required(), Select::make('project_id')->relationship('project', 'name')->searchable()->preload()->nullable(), TextInput::make('title')->required()->maxLength(255), Textarea::make('scope')->required()->rows(5)->columnSpanFull(), Select::make('pricing_model')->options(EngagementPricingModel::options())->required()->default('fixed'), TextInput::make('amount')->numeric()->minValue(0)->helperText('Integer minor units: EUR cents; XOF whole units.'), Select::make('currency')->options(Currency::options())->required()->default('EUR'), Select::make('status')->options(EngagementStatus::options())->required()->default('proposal'), DatePicker::make('started_at'), DatePicker::make('ended_at')]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('title')->searchable()->sortable(), TextColumn::make('client.name')->label('Client')->searchable(), TextColumn::make('status')->badge()->formatStateUsing(fn ($state): string => $state?->label() ?? ''), TextColumn::make('amount')->numeric()->placeholder('À définir'), TextColumn::make('currency')->formatStateUsing(fn ($state): string => $state?->value ?? '')])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListEngagements::route('/'), 'create' => CreateEngagement::route('/create'), 'edit' => EditEngagement::route('/{record}/edit')];
    }
}
