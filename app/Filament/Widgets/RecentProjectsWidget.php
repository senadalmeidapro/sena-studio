<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Widgets\Widget;

class RecentProjectsWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-projects-widget';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 6,
    ];

    public function getViewData(): array
    {
        return [
            'projects' => Project::query()
                ->latest('started_at')
                ->take(5)
                ->get(),
            'resourceUrl' => ProjectResource::getUrl('index'),
        ];
    }
}
