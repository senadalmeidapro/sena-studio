<?php

namespace App\Filament\Resources\AuditLogs\Pages;

use App\Filament\Resources\AuditLogs\AuditLogResource;
use App\Filament\Widgets\AdminActivityChartWidget;
use App\Filament\Widgets\AuditLogStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListAuditLogs extends ListRecords
{
    protected static string $resource = AuditLogResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            AuditLogStatsWidget::class,
            AdminActivityChartWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 2;
    }
}
