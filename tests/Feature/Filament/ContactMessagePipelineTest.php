<?php

use App\Filament\Resources\Messages\Pages\ListContactMessages;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('updates a contact pipeline from the messages table', function () {
    $user = User::factory()->create();
    $message = ContactMessage::create([
        'name' => 'Client test',
        'email' => 'client@example.com',
        'subject' => 'Projet API',
        'message' => 'Je souhaite discuter d’une API métier.',
    ]);

    Livewire::actingAs($user)
        ->test(ListContactMessages::class)
        ->callTableAction('updatePipeline', $message, [
            'status' => ContactMessage::STATUS_PROPOSAL,
            'priority' => ContactMessage::PRIORITY_HIGH,
            'follow_up_at' => now()->addDay()->toDateTimeString(),
            'internal_notes' => 'Relancer après envoi de la proposition.',
        ])
        ->assertHasNoFormErrors();

    $message->refresh();

    expect($message->status)->toBe(ContactMessage::STATUS_PROPOSAL)
        ->and($message->priority)->toBe(ContactMessage::PRIORITY_HIGH)
        ->and($message->follow_up_at)->not->toBeNull()
        ->and($message->internal_notes)->toBe('Relancer après envoi de la proposition.');
});
