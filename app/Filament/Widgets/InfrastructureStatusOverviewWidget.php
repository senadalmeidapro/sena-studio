<?php

namespace App\Filament\Widgets;

use App\Enums\InfraEnvironment;
use App\Models\Infra;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InfrastructureStatusOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'System';

    protected ?string $description = 'Infrastructure health and environment coverage.';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Active Infra', number_format(Infra::query()->where('is_active', true)->count()))
                ->description('Available infrastructure profiles')
                ->color('success'),
            Stat::make('Inactive Infra', number_format(Infra::query()->where('is_active', false)->count()))
                ->description('Profiles currently disabled')
                ->color('danger'),
            Stat::make('Production Infra', number_format(Infra::query()->where('environment', InfraEnvironment::Production->value)->count()))
                ->description('Production-ready environments')
                ->color('warning'),
            Stat::make('Total CPU Cores', number_format((int) Infra::query()->sum('cpu_cores')))
                ->description('Provisioned compute across infra records')
                ->color('info'),
            Stat::make('Total Memory (MB)', number_format((int) Infra::query()->sum('memory_mb')))
                ->description('Provisioned memory across infra records')
                ->color('gray'),
            Stat::make('Total Storage (GB)', number_format((int) Infra::query()->sum('storage_gb')))
                ->description('Provisioned storage across infra records')
                ->color('primary'),
        ];
    }
}
