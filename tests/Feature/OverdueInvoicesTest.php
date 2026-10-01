<?php

use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Enums\InvoiceStatus;
use App\Filament\Resources\Engagements\Pages\ListEngagements;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Models\Client;
use App\Models\Engagement;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\OverdueInvoiceDigest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('marks sent invoices overdue and sends one admin digest per day', function () {
    $this->travelTo(now()->setDate(2026, 10, 6)->startOfDay());
    $admin = User::factory()->admin()->create();
    $engagement = Engagement::factory()->create(['title' => 'API work']);
    $pastDue = Invoice::factory()->for($engagement)->create([
        'number' => 'INV-PAST',
        'due_at' => today()->subDay(),
        'status' => InvoiceStatus::Sent,
    ]);
    $pastDueSecond = Invoice::factory()->for($engagement)->create([
        'number' => 'INV-PAST-2',
        'due_at' => today()->subDays(3),
        'status' => InvoiceStatus::Sent,
    ]);
    $dueToday = Invoice::factory()->for($engagement)->create([
        'number' => 'INV-TODAY',
        'due_at' => today(),
        'status' => InvoiceStatus::Sent,
    ]);

    Artisan::call('invoices:remind');

    expect($pastDue->fresh()->status)->toBe(InvoiceStatus::Overdue)
        ->and($pastDueSecond->fresh()->status)->toBe(InvoiceStatus::Overdue)
        ->and($dueToday->fresh()->status)->toBe(InvoiceStatus::Sent);

    $notification = $admin->notifications()->sole();
    expect($notification->type)->toBe(OverdueInvoiceDigest::class)
        ->and($notification->data['count'])->toBe(2)
        ->and(collect($notification->data['invoices'])->pluck('number')->all())->toEqualCanonicalizing(['INV-PAST', 'INV-PAST-2']);

    Artisan::call('invoices:remind');

    expect($admin->notifications()->count())->toBe(1)
        ->and(DB::table('invoice_reminders')->whereDate('reminded_on', today())->count())->toBe(2);
});

it('does not create invoice reminders or admin notifications when no invoices are overdue', function () {
    $admin = User::factory()->admin()->create();
    $engagement = Engagement::factory()->create();
    Invoice::factory()->for($engagement)->create([
        'due_at' => today(),
        'status' => InvoiceStatus::Sent,
    ]);

    Artisan::call('invoices:remind');

    expect($admin->notifications()->count())->toBe(0)
        ->and(DB::table('invoice_reminders')->count())->toBe(0);
});

it('marks an invoice paid from its admin table action', function () {
    $admin = User::factory()->admin()->create();
    $invoice = Invoice::factory()->create(['status' => InvoiceStatus::Sent, 'paid_at' => null]);

    Livewire::actingAs($admin)
        ->test(ListInvoices::class)
        ->callTableAction('markAsPaid', $invoice)
        ->assertHasNoTableActionErrors();

    expect($invoice->fresh()->status)->toBe(InvoiceStatus::Paid)
        ->and($invoice->fresh()->paid_at->toDateString())->toBe(today()->toDateString());
});

it('creates the next monthly retainer invoice from the latest invoice', function () {
    $admin = User::factory()->admin()->create();
    $client = Client::factory()->create();
    $engagement = Engagement::factory()->for($client)->create([
        'pricing_model' => EngagementPricingModel::Retainer,
        'amount' => 87500,
        'currency' => Currency::EUR,
    ]);
    $last = Invoice::factory()->for($engagement)->create([
        'number' => '2026-007',
        'amount' => 87500,
        'currency' => Currency::EUR,
        'issued_at' => '2026-09-10',
        'due_at' => '2026-09-25',
        'status' => InvoiceStatus::Sent,
    ]);

    Livewire::actingAs($admin)
        ->test(ListEngagements::class)
        ->assertTableActionExists('createNextMonthlyInvoice', record: $engagement)
        ->callTableAction('createNextMonthlyInvoice', $engagement)
        ->assertHasNoTableActionErrors();

    $next = $engagement->invoices()->where('id', '!=', $last->id)->sole();
    expect($next->number)->toBe('2026-008')
        ->and($next->amount)->toBe(87500)
        ->and($next->currency)->toBe(Currency::EUR)
        ->and($next->issued_at->toDateString())->toBe('2026-10-10')
        ->and($next->due_at->toDateString())->toBe('2026-10-25')
        ->and($next->status)->toBe(InvoiceStatus::Draft);
});

it('registers overdue invoice reminders in the daily scheduler without client email', function () {
    $admin = User::factory()->admin()->create();

    expect((new OverdueInvoiceDigest([], today()->toDateString()))->via($admin))->toBe(['database']);

    $this->artisan('schedule:list')
        ->expectsOutputToContain('invoices:remind');
});
