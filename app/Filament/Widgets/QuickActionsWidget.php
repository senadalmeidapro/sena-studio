<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\ContactMessageResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Skills\SkillResource;
use App\Filament\Resources\Stacks\StackResource;
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
                ['label' => 'Nouvelle stack', 'url' => StackResource::getUrl('create'), 'color' => 'info'],
                ['label' => 'Nouvelle compétence', 'url' => SkillResource::getUrl('create'), 'color' => 'success'],
                ['label' => 'Voir les messages', 'url' => ContactMessageResource::getUrl('index'), 'color' => 'warning'],
            ],
        ];
    }
}
