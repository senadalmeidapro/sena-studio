<?php

namespace App\Support\Reports;

use App\Enums\Currency;
use App\Enums\InvoiceStatus;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Invoice;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class ReportData
{
    public const RANGES = [
        'this_month' => 'This month',
        'last_3_months' => 'Last 3 months',
        'this_year' => 'This year',
        'all_time' => 'All time',
    ];

    public function forRange(string $range): array
    {
        $range = array_key_exists($range, self::RANGES) ? $range : 'this_month';
        [$start, $end] = $this->bounds($range);

        $paidQuery = Invoice::query()
            ->with(['engagement.project'])
            ->where('status', InvoiceStatus::Paid->value)
            ->whereNotNull('paid_at')
            ->when($start, fn ($query) => $query->whereDate('paid_at', '>=', $start->toDateString()))
            ->when($end, fn ($query) => $query->whereDate('paid_at', '<=', $end->toDateString()));

        $paidInvoices = $paidQuery->get();

        $revenueByMonth = $paidInvoices
            ->groupBy(fn (Invoice $invoice): string => $invoice->paid_at->format('Y-m'))
            ->flatMap(fn (Collection $monthInvoices, string $month): Collection => $monthInvoices
                ->groupBy(fn (Invoice $invoice): string => $invoice->currency->value)
                ->map(fn (Collection $currencyInvoices, string $currency): array => [
                    'month' => $month,
                    'currency' => $currency,
                    'amount' => $currencyInvoices->sum('amount'),
                ])->values())
            ->sortBy(fn (array $row): string => $row['month'].'-'.$row['currency'])
            ->values()
            ->all();

        $openInvoices = Invoice::query()
            ->whereIn('status', [InvoiceStatus::Sent->value, InvoiceStatus::Overdue->value])
            ->whereNull('paid_at')
            ->when($start, fn ($query) => $query->whereDate('issued_at', '>=', $start->toDateString()))
            ->when($end, fn ($query) => $query->whereDate('issued_at', '<=', $end->toDateString()))
            ->get(['amount', 'currency']);

        $openReceivables = collect(Currency::cases())
            ->mapWithKeys(fn (Currency $currency): array => [
                $currency->value => (int) $openInvoices->where('currency', $currency)->sum('amount'),
            ])
            ->all();

        $leads = ContactMessage::query()
            ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start->toDateString()))
            ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end->toDateString()))
            ->get(['id', 'client_id', 'created_at']);
        $convertedLeads = $leads->whereNotNull('client_id')->count();

        $daysToFirstEngagement = Client::query()
            ->withMin('contactMessages', 'created_at')
            ->withMin('engagements', 'created_at')
            ->get()
            ->filter(fn (Client $client): bool => $client->contact_messages_min_created_at !== null
                && $client->engagements_min_created_at !== null)
            ->filter(function (Client $client) use ($start, $end): bool {
                $firstMessage = CarbonImmutable::parse($client->contact_messages_min_created_at);

                return $this->contains($firstMessage, $start, $end);
            })
            ->map(function (Client $client): ?float {
                $firstMessage = CarbonImmutable::parse($client->contact_messages_min_created_at);
                $firstEngagement = CarbonImmutable::parse($client->engagements_min_created_at);

                if ($firstEngagement->lessThan($firstMessage)) {
                    return null;
                }

                return $firstMessage->diffInHours($firstEngagement) / 24;
            })
            ->filter(fn (?float $days): bool => $days !== null);

        $revenueByProjectType = $paidInvoices
            ->groupBy(function (Invoice $invoice): string {
                $type = $invoice->engagement?->project?->type;

                return $type?->label() ?? 'Unlinked project';
            })
            ->flatMap(fn (Collection $typeInvoices, string $type): Collection => $typeInvoices
                ->groupBy(fn (Invoice $invoice): string => $invoice->currency->value)
                ->map(fn (Collection $currencyInvoices, string $currency): array => [
                    'project_type' => $type,
                    'currency' => $currency,
                    'amount' => $currencyInvoices->sum('amount'),
                ])->values())
            ->sortBy(fn (array $row): string => $row['project_type'].'-'.$row['currency'])
            ->values()
            ->all();

        return [
            'range' => $range,
            'revenue_by_month' => $revenueByMonth,
            'open_receivables' => $openReceivables,
            'lead_conversion' => [
                'converted' => $convertedLeads,
                'total' => $leads->count(),
                'rate' => $leads->isEmpty() ? 0 : round(($convertedLeads / $leads->count()) * 100, 1),
            ],
            'average_days_to_first_engagement' => $daysToFirstEngagement->isEmpty()
                ? null
                : round($daysToFirstEngagement->avg(), 1),
            'revenue_by_project_type' => $revenueByProjectType,
        ];
    }

    private function bounds(string $range): array
    {
        $today = CarbonImmutable::instance(now())->startOfDay();

        return match ($range) {
            'this_month' => [$today->startOfMonth(), $today],
            'last_3_months' => [$today->startOfMonth()->subMonthsNoOverflow(2), $today],
            'this_year' => [$today->startOfYear(), $today],
            'all_time' => [null, null],
            default => [$today->startOfMonth(), $today],
        };
    }

    private function contains(CarbonInterface $date, ?CarbonInterface $start, ?CarbonInterface $end): bool
    {
        return ($start === null || $date->greaterThanOrEqualTo($start))
            && ($end === null || $date->lessThanOrEqualTo($end->endOfDay()));
    }
}
