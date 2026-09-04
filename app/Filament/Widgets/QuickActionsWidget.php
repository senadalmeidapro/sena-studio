<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Skills\SkillResource;
use App\Filament\Resources\Stacks\StackResource;
use App\Filament\Resources\Users\UserResource;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected string $view = 'filament.widgets.quick-actions-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'actions' => [
                ['label' => 'Create User', 'url' => UserResource::getUrl('create')],
                ['label' => 'Create Project', 'url' => ProjectResource::getUrl('create')],
                ['label' => 'Create Stack', 'url' => StackResource::getUrl('create')],
                ['label' => 'Create Skill', 'url' => SkillResource::getUrl('create')],
            ],
        ];
    }
}
