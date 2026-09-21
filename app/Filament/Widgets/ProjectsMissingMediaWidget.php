<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Widgets\Widget;

class ProjectsMissingMediaWidget extends Widget
{
    protected string $view = 'filament.widgets.projects-missing-media-widget';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 4,
    ];

    public function getViewData(): array
    {
        return [
            'projects' => Project::query()
                ->where('visibility', 'public')
                ->where('status', '!=', 'cancelled')
                ->where('slug', '!=', 'portfolio-sena-studio')
                ->where(function ($query): void {
                    $query->whereNull('image')
                        ->orWhereDoesntHave('projectImages');
                })
                ->latest()
                ->take(8)
                ->get(),
            'resourceUrl' => ProjectResource::getUrl('index'),
        ];
    }
}
