<?php

namespace App\Filament\Widgets;

use App\Enums\EngagementStatus;
use App\Enums\InvoiceStatus;
use App\Models\Engagement;
use App\Models\Invoice;
use Filament\Widgets\Widget;

class ActiveEngagementsAndOverdueInvoicesWidget extends Widget
{
    protected string $view = 'filament.widgets.active-engagements-and-overdue-invoices-widget';

    protected int|string|array $columnSpan = ['md' => 1, 'xl' => 6];

    public function getViewData(): array
    {
        return [
            'activeEngagements' => Engagement::query()->where('status', EngagementStatus::Active->value)->count(),
            'overdueInvoices' => Invoice::query()
                ->whereNull('paid_at')
                ->whereNotNull('due_at')
                ->whereDate('due_at', '<', today())
                ->whereIn('status', [InvoiceStatus::Sent->value, InvoiceStatus::Overdue->value])
                ->count(),
        ];
    }
}
