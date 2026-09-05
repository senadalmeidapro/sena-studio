<?php

namespace App\Filament\Resources\Cvs;

use App\Filament\Resources\Cvs\Pages\CreateCv;
use App\Filament\Resources\Cvs\Pages\EditCv;
use App\Filament\Resources\Cvs\Pages\ListCvs;
use App\Filament\Resources\Cvs\Schemas\CvForm;
use App\Filament\Resources\Cvs\Tables\CvsTable;
use App\Models\Cv;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CvResource extends Resource
{
    protected static ?string $model = Cv::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'version_label';

    protected static UnitEnum|string|null $navigationGroup = 'Canvas';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'CV';

    protected static ?string $pluralModelLabel = 'CVs';

    protected static ?string $navigationLabel = 'CVs';

    public static function getNavigationBadge(): ?string
    {
        return (string) Cv::published()->count();
    }

    public static function getNavigationBadgeColor(): array|string|null
    {
        return 'success';
    }

    public static function form(Schema $schema): Schema
    {
        return CvForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CvsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCvs::route('/'),
            'create' => CreateCv::route('/create'),
            'edit' => EditCv::route('/{record}/edit'),
        ];
    }
}
