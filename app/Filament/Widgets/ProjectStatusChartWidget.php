<?php

namespace App\Filament\Widgets;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Filament\Widgets\DoughnutChartWidget;

class ProjectStatusChartWidget extends DoughnutChartWidget
{
    protected ?string $heading = 'Projets par statut';

    protected ?string $description = 'Répartition des projets selon leur cycle de vie.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 4,
    ];

    protected function getData(): array
    {
        $stats = Project::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = [];
        $values = [];

        foreach (ProjectStatus::cases() as $status) {
            $count = (int) ($stats[$status->value] ?? 0);
            $labels[] = $status->label();
            $values[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projets',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
