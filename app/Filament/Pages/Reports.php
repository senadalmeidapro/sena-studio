<?php

namespace App\Filament\Pages;

use App\Support\Reports\ReportData;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Reports extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static UnitEnum|string|null $navigationGroup = 'Clients';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Reports';

    protected string $view = 'filament.pages.reports';

    public string $range = 'this_month';

    public function getViewData(): array
    {
        return [
            'ranges' => ReportData::RANGES,
            'report' => app(ReportData::class)->forRange($this->range),
        ];
    }
}
