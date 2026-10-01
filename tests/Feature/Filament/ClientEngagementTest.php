<?php

use App\Actions\ConvertContactMessageToClient;
use App\Enums\Currency;
use App\Enums\EngagementStatus;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\Deliverables\DeliverableResource;
use App\Filament\Resources\Engagements\EngagementResource;
use App\Filament\Resources\Invoices\InvoiceResource;
use App\Filament\Resources\Messages\Pages\ListContactMessages;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Deliverable;
use App\Models\Engagement;
use App\Models\Invoice;
use App\Models\User;
use Livewire\Livewire;

it('converts a contact message into one client and an initial proposal', function () {
    $message = ContactMessage::create([
        'name' => 'Awa Diallo', 'email' => 'awa@example.test', 'company' => 'Learning Co',
        'subject' => 'Learning platform', 'project_type' => 'edtech_platform', 'goal' => 'Build a learning platform.', 'timeline' => '3_6_months', 'budget_range' => '5k-15k', 'message' => 'Integrate the existing course catalogue.',
    ]);

    $client = app(ConvertContactMessageToClient::class)->handle($message, [
        'name' => 'Awa Diallo', 'email' => 'awa@example.test', 'company' => 'Learning Co',
        'title' => 'Learning platform', 'scope' => 'Build a platform.', 'currency' => 'EUR',
    ]);

    expect(Client::count())->toBe(1)
        ->and(Engagement::count())->toBe(1)
        ->and($client->email)->toBe('awa@example.test')
        ->and($message->fresh()->client_id)->toBe($client->id)
        ->and($message->fresh()->status)->toBe(ContactMessage::STATUS_PROPOSAL)
        ->and($client->engagements->first()->status)->toBe(EngagementStatus::Proposal)
        ->and($client->engagements->first()->scope)->toContain('5 000');

    expect(app(ConvertContactMessageToClient::class)->handle($message->fresh(), [])->id)->toBe($client->id)
        ->and(Engagement::count())->toBe(1);
});

it('stores engagement and invoice amounts as integer minor units and supports both currencies', function () {
    $engagement = Engagement::factory()->create(['amount' => 12345, 'currency' => Currency::EUR]);
    $invoice = Invoice::factory()->create(['engagement_id' => $engagement->id, 'amount' => 5000, 'currency' => Currency::XOF]);
    $deliverable = Deliverable::factory()->create(['engagement_id' => $engagement->id]);

    expect($engagement->fresh()->amount)->toBe(12345)
        ->and($engagement->fresh()->currency)->toBe(Currency::EUR)
        ->and($invoice->fresh()->amount)->toBe(5000)
        ->and($invoice->fresh()->currency)->toBe(Currency::XOF)
        ->and($deliverable->engagement->is($engagement))->toBeTrue();
});

it('exposes all client tracker resources to an admin', function () {
    $user = User::factory()->create(['is_admin' => true]);

    foreach ([ClientResource::getUrl('index'), EngagementResource::getUrl('index'), DeliverableResource::getUrl('index'), InvoiceResource::getUrl('index')] as $url) {
        $this->actingAs($user)->get($url)->assertSuccessful();
    }
});

it('offers the contact conversion as a one-click admin table action', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $message = ContactMessage::create([
        'name' => 'Kofi Mensah', 'email' => 'kofi@example.test', 'company' => 'Fintech Ltd',
        'subject' => 'API build', 'project_type' => 'fintech_api', 'goal' => 'Need an API.', 'timeline' => '1_3_months', 'budget_range' => '1k-5k', 'message' => 'Connect to the ledger.',
    ]);

    Livewire::actingAs($user)
        ->test(ListContactMessages::class)
        ->callTableAction('convertToClient', $message, [
            'name' => 'Kofi Mensah', 'email' => 'kofi@example.test', 'company' => 'Fintech Ltd',
            'title' => 'API build', 'scope' => 'Need an API.', 'pricing_model' => 'fixed',
            'currency' => 'EUR',
        ])
        ->assertHasNoFormErrors();

    expect($message->fresh()->client)->not->toBeNull()
        ->and(Engagement::where('client_id', $message->fresh()->client_id)->count())->toBe(1);
});
