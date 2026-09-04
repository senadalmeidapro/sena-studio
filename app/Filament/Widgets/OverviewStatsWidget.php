<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Models\Infra;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Overview';

    protected ?string $description = 'Core SaaS KPIs across users, projects, skills, stacks, and infrastructure.';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', number_format(User::query()->count()))
                ->description('Registered platform users')
                ->color('primary'),
            Stat::make('Total Projects', number_format(Project::query()->count()))
                ->description('Projects tracked in the platform')
                ->color('success'),
            Stat::make('Total Skills', number_format(Skill::query()->count()))
                ->description('Skills available for staffing and delivery')
                ->color('warning'),
            Stat::make('Total Stacks', number_format(Stack::query()->count()))
                ->description('Reusable technology stacks')
                ->color('info'),
            Stat::make('Active Projects', number_format(Project::query()->where('status', ProjectStatus::Production->value)->count()))
                ->description('Projects currently in production')
                ->color('success'),
            Stat::make('Infra Count', number_format(Infra::query()->count()))
                ->description('Infrastructure definitions provisioned')
                ->color('gray'),
        ];
    }
}
