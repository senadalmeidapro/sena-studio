<?php

use App\Filament\Resources\Messages\Pages\ListContactMessages;
use App\Models\ContactMessage;
use App\Models\User;
use App\Support\ContactMessageReplyDraft;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('uses the correct localized reply draft for each pipeline stage', function () {
    $drafts = app(ContactMessageReplyDraft::class);
    $lead = ContactMessage::create([
        'name' => 'Alex',
        'email' => 'alex@example.test',
        'subject' => 'API delivery',
        'message' => 'Project enquiry.',
        'status' => ContactMessage::STATUS_NEW,
    ]);

    app()->setLocale('en');
    expect($drafts->for($lead))->toContain('Thanks for sharing API delivery');

    $lead->update(['status' => ContactMessage::STATUS_PROPOSAL]);
    expect($drafts->for($lead))->toContain('following up on the proposal');

    $lead->update(['status' => ContactMessage::STATUS_QUALIFYING]);
    expect($drafts->for($lead))->toContain('checking in about API delivery');

    app()->setLocale('fr');
    expect($drafts->for($lead))->toContain('Bonjour Alex');
});

it('opens a copy-only reply draft action on a lead', function () {
    $admin = User::factory()->admin()->create();
    $lead = ContactMessage::create([
        'name' => 'Alex',
        'email' => 'alex@example.test',
        'subject' => 'API delivery',
        'message' => 'Project enquiry.',
        'status' => ContactMessage::STATUS_NEW,
    ]);

    Livewire::actingAs($admin)
        ->test(ListContactMessages::class)
        ->assertTableActionExists('copyReplyDraft', record: $lead)
        ->assertSee(__('leads.reply_draft.action'));

    $html = view('filament.messages.reply-draft', [
        'draft' => app(ContactMessageReplyDraft::class)->for($lead),
    ])->render();

    expect($html)->toContain('Thanks for sharing API delivery')
        ->and($html)->toContain('navigator.clipboard.writeText');
});
