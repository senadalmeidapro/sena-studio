<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AuditLogs\AuditLogResource;
use App\Models\AdminActivityLog;
use Filament\Widgets\Widget;

class RecentActivityWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-activity-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'activities' => AdminActivityLog::query()
                ->latest()
                ->take(12)
                ->get(),
            'resourceUrl' => AuditLogResource::getUrl('index'),
        ];
    }
}
