<?php

use App\Enums\Currency;
use App\Enums\EngagementStatus;
use App\Enums\InvoiceStatus;
use App\Enums\ProjectType;
use App\Filament\Pages\Reports;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Engagement;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use App\Support\Reports\ReportData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function reportInvoice(array $attributes = []): Invoice
{
    $invoice = Invoice::factory()->create($attributes);

    if (isset($attributes['created_at'])) {
        $invoice->forceFill(['created_at' => $attributes['created_at']])->save();
    }

    return $invoice->refresh();
}

function reportLead(array $attributes = []): ContactMessage
{
    $lead = ContactMessage::create(array_replace([
        'name' => 'Report lead',
        'email' => 'report@example.test',
        'subject' => 'Report inquiry',
        'message' => 'A lead for reporting.',
        'status' => ContactMessage::STATUS_NEW,
    ], $attributes));

    if (isset($attributes['created_at'])) {
        $lead->forceFill(['created_at' => $attributes['created_at']])->save();
    }

    return $lead->refresh();
}

it('aggregates revenue and receivables separately per currency and computes lead conversion', function () {
    $this->travelTo(now()->setDate(2026, 10, 20)->startOfDay());
    $client = Client::factory()->create();
    $project = Project::factory()->create(['type' => ProjectType::Web]);
    $engagement = Engagement::factory()->for($client)->for($project)->create([
        'status' => EngagementStatus::Active,
    ]);
    $unlinkedEngagement = Engagement::factory()->create();

    reportInvoice([
        'engagement_id' => $engagement->id,
        'number' => 'R-EUR',
        'amount' => 12500,
        'currency' => Currency::EUR,
        'status' => InvoiceStatus::Paid,
        'paid_at' => '2026-10-01',
        'issued_at' => '2026-10-01',
    ]);
    reportInvoice([
        'engagement_id' => $unlinkedEngagement->id,
        'number' => 'R-XOF',
        'amount' => 250000,
        'currency' => Currency::XOF,
        'status' => InvoiceStatus::Paid,
        'paid_at' => '2026-10-20',
        'issued_at' => '2026-10-02',
    ]);
    reportInvoice([
        'engagement_id' => $engagement->id,
        'number' => 'OPEN-EUR',
        'amount' => 3200,
        'currency' => Currency::EUR,
        'status' => InvoiceStatus::Sent,
        'issued_at' => '2026-10-20',
    ]);
    reportInvoice([
        'engagement_id' => $engagement->id,
        'number' => 'OPEN-XOF',
        'amount' => 54000,
        'currency' => Currency::XOF,
        'status' => InvoiceStatus::Overdue,
        'issued_at' => '2026-10-01',
    ]);
    reportInvoice([
        'engagement_id' => $engagement->id,
        'number' => 'OLD-OPEN',
        'amount' => 9000,
        'currency' => Currency::EUR,
        'status' => InvoiceStatus::Sent,
        'issued_at' => '2026-09-30',
    ]);

    reportLead(['client_id' => $client->id, 'created_at' => '2026-10-02 08:00:00']);
    reportLead(['created_at' => '2026-10-20 08:00:00']);
    reportLead(['created_at' => '2026-09-30 08:00:00']);
    $engagement->forceFill(['created_at' => '2026-10-11 08:00:00'])->save();

    $report = app(ReportData::class)->forRange('this_month');

    expect($report['revenue_by_month'])->toEqual([
        ['month' => '2026-10', 'currency' => 'EUR', 'amount' => 12500],
        ['month' => '2026-10', 'currency' => 'XOF', 'amount' => 250000],
    ])
        ->and($report['open_receivables'])->toBe(['XOF' => 54000, 'EUR' => 3200])
        ->and($report['lead_conversion'])->toBe(['converted' => 1, 'total' => 2, 'rate' => 50.0])
        ->and($report['average_days_to_first_engagement'])->toBe(9.0)
        ->and($report['revenue_by_project_type'])->toEqual([
            ['project_type' => 'Unlinked project', 'currency' => 'XOF', 'amount' => 250000],
            ['project_type' => 'Web', 'currency' => 'EUR', 'amount' => 12500],
        ]);
});

it('applies this month, last three months, this year, and all-time boundaries', function () {
    $this->travelTo(now()->setDate(2026, 10, 20)->startOfDay());
    $engagement = Engagement::factory()->create();

    reportInvoice(['engagement_id' => $engagement->id, 'number' => 'THIS-MONTH-START', 'amount' => 100, 'status' => InvoiceStatus::Paid, 'paid_at' => '2026-10-01']);
    reportInvoice(['engagement_id' => $engagement->id, 'number' => 'THIS-MONTH-END', 'amount' => 200, 'status' => InvoiceStatus::Paid, 'paid_at' => '2026-10-20']);
    reportInvoice(['engagement_id' => $engagement->id, 'number' => 'LAST-3-START', 'amount' => 300, 'status' => InvoiceStatus::Paid, 'paid_at' => '2026-08-01']);
    reportInvoice(['engagement_id' => $engagement->id, 'number' => 'THIS-YEAR-START', 'amount' => 400, 'status' => InvoiceStatus::Paid, 'paid_at' => '2026-01-01']);
    reportInvoice(['engagement_id' => $engagement->id, 'number' => 'PRIOR-YEAR', 'amount' => 500, 'status' => InvoiceStatus::Paid, 'paid_at' => '2025-12-31']);

    $reportData = app(ReportData::class);
    $month = $reportData->forRange('this_month');
    $lastThreeMonths = $reportData->forRange('last_3_months');
    $year = $reportData->forRange('this_year');
    $allTime = $reportData->forRange('all_time');

    expect(array_sum(array_column($month['revenue_by_month'], 'amount')))->toBe(300)
        ->and(array_sum(array_column($lastThreeMonths['revenue_by_month'], 'amount')))->toBe(600)
        ->and(array_sum(array_column($year['revenue_by_month'], 'amount')))->toBe(1000)
        ->and(array_sum(array_column($allTime['revenue_by_month'], 'amount')))->toBe(1500);
});

it('returns empty report values safely and renders the separate admin Reports page', function () {
    $report = app(ReportData::class)->forRange('this_month');

    expect($report['revenue_by_month'])->toBe([])
        ->and($report['open_receivables'])->toBe(['XOF' => 0, 'EUR' => 0])
        ->and($report['lead_conversion'])->toBe(['converted' => 0, 'total' => 0, 'rate' => 0])
        ->and($report['average_days_to_first_engagement'])->toBeNull()
        ->and($report['revenue_by_project_type'])->toBe([]);

    Livewire::actingAs(User::factory()->admin()->create())
        ->test(Reports::class)
        ->assertSee('Paid revenue by month')
        ->assertSee('Lead to client conversion')
        ->set('range', 'all_time')
        ->assertSet('range', 'all_time');
});
