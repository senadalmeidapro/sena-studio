<?php

use App\Enums\Currency;
use App\Filament\Resources\Engagements\Pages\ListEngagements;
use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Models\Client;
use App\Models\Engagement;
use App\Models\Invoice;
use App\Models\User;
use App\Support\BillingIssuer;
use App\Support\InvoiceNumberGenerator;
use App\Support\MoneyFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function configureBillingIssuer(): void
{
    config([
        'services.billing.issuer.legal_name' => 'Configured Studio Ltd',
        'services.billing.issuer.address' => 'Configured address',
        'services.billing.issuer.tax_id' => 'Configured tax ID',
        'services.billing.issuer.bank_details' => 'Configured bank details',
        'services.billing.issuer.payment_details' => 'Configured payment details',
        'services.billing.quote_validity_days' => 21,
        'services.billing.payment_terms' => 'Configured payment terms',
    ]);
}

it('formats euros in cents and XOF in whole units', function () {
    $formatter = app(MoneyFormatter::class);

    expect($formatter->format(12345, Currency::EUR))->toBe('123,45 EUR')
        ->and($formatter->format(12345, Currency::XOF))->toBe('12 345 XOF');
});

it('generates quote and invoice PDFs on demand for an admin', function () {
    configureBillingIssuer();
    $admin = User::factory()->admin()->create();
    $client = Client::factory()->create(['name' => 'PDF Client', 'company' => 'Example Company']);
    $engagement = Engagement::factory()->for($client)->create([
        'title' => 'API delivery',
        'scope' => 'Build a service API.',
        'amount' => 12345,
        'currency' => Currency::EUR,
    ]);
    $invoice = Invoice::factory()->for($engagement)->create([
        'number' => '2026-042',
        'amount' => 150000,
        'currency' => Currency::XOF,
        'issued_at' => '2026-10-01',
        'due_at' => '2026-10-31',
    ]);

    $quoteResponse = $this->actingAs($admin)->get(route('admin.billing.engagements.quote', $engagement));
    $quoteResponse->assertSuccessful()
        ->assertHeader('content-type', 'application/pdf')
        ->assertHeader('content-disposition', 'attachment; filename=Quote-'.$engagement->id.'.pdf');
    expect(substr($quoteResponse->getContent(), 0, 5))->toBe('%PDF-')
        ->and(strlen($quoteResponse->getContent()))->toBeGreaterThan(1000);

    $invoiceResponse = $this->actingAs($admin)->get(route('admin.billing.invoices.pdf', $invoice));
    $invoiceResponse->assertSuccessful()
        ->assertHeader('content-type', 'application/pdf')
        ->assertHeader('content-disposition', 'attachment; filename=Invoice-2026-042.pdf');
    expect(substr($invoiceResponse->getContent(), 0, 5))->toBe('%PDF-')
        ->and(strlen($invoiceResponse->getContent()))->toBeGreaterThan(1000);
});

it('shows TODO values for a local PDF when issuer details are missing', function () {
    config(['services.billing.issuer' => []]);

    expect(app(BillingIssuer::class)->details())
        ->toMatchArray([
            'legal_name' => 'TODO: FIX ME — configure billing issuer legal name',
            'tax_id' => 'TODO: FIX ME — configure billing issuer tax id',
            'payment_details' => 'TODO: FIX ME — configure billing issuer payment details',
        ]);
});

it('blocks PDF generation in production when issuer details are missing', function () {
    config(['services.billing.issuer' => []]);
    app()->detectEnvironment(fn (): string => 'production');

    $response = $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.billing.invoices.pdf', Invoice::factory()->create()));

    $response->assertStatus(503)->assertSeeText('Configure these billing issuer values first');
});

it('generates invoice numbers sequentially and restarts the sequence each year', function () {
    $generator = app(InvoiceNumberGenerator::class);
    $client = Client::factory()->create();
    $engagement = Engagement::factory()->for($client)->create();

    Invoice::factory()->for($engagement)->create(['number' => '2026-003']);
    Invoice::factory()->for($engagement)->create(['number' => '2026-010']);

    expect($generator->next(2026))->toBe('2026-011')
        ->and($generator->next(2027))->toBe('2027-001');
});

it('creates an admin invoice using the generated number while allowing an override', function () {
    $admin = User::factory()->admin()->create();
    $client = Client::factory()->create();
    $engagement = Engagement::factory()->for($client)->create();
    Invoice::factory()->for($engagement)->create(['number' => '2026-004']);

    Livewire\Livewire::actingAs($admin)
        ->test(CreateInvoice::class)
        ->fillForm([
            'engagement_id' => $engagement->id,
            'amount' => 12500,
            'currency' => 'EUR',
            'status' => 'draft',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Invoice::query()->where('number', '2026-005')->exists())->toBeTrue();
});

it('shows PDF download actions on engagement and invoice tables', function () {
    $admin = User::factory()->admin()->create();
    $client = Client::factory()->create();
    $engagement = Engagement::factory()->for($client)->create();
    $invoice = Invoice::factory()->for($engagement)->create();

    Livewire\Livewire::actingAs($admin)
        ->test(ListEngagements::class)
        ->assertTableActionExists('downloadQuote', record: $engagement);

    Livewire\Livewire::actingAs($admin)
        ->test(ListInvoices::class)
        ->assertTableActionExists('downloadInvoice', record: $invoice);
});
