<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\ContactMessageResource;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected string $view = 'filament.widgets.quick-actions-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'actions' => [
                ['label' => 'Nouveau projet', 'url' => ProjectResource::getUrl('create'), 'color' => 'primary'],
                ['label' => 'Nouvel article', 'url' => PostResource::getUrl('create'), 'color' => 'info'],
                ['label' => 'Voir les messages', 'url' => ContactMessageResource::getUrl('index'), 'color' => 'warning'],
            ],
        ];
    }
}
