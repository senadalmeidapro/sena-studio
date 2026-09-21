<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('prunes contact messages older than the configured retention period', function () {
    $expired = ContactMessage::create([
        'name' => 'Expired',
        'email' => 'expired@example.com',
        'subject' => 'Old request',
        'message' => 'An old request that should be removed after retention.',
    ]);
    $expired->forceFill([
        'created_at' => now()->subYears(4),
        'updated_at' => now()->subYears(4),
    ])->saveQuietly();
    $current = ContactMessage::create([
        'name' => 'Current',
        'email' => 'current@example.com',
        'subject' => 'Current request',
        'message' => 'A current request that must remain available.',
    ]);

    $this->artisan('contact-messages:prune')->assertSuccessful();

    expect(ContactMessage::find($expired->id))->toBeNull()
        ->and(ContactMessage::find($current->id))->not->toBeNull();
});

it('supports a dry run without deleting contact messages', function () {
    $message = ContactMessage::create([
        'name' => 'Expired',
        'email' => 'expired@example.com',
        'subject' => 'Old request',
        'message' => 'An old request that should only be reported in dry run.',
    ]);
    $message->forceFill([
        'created_at' => now()->subYears(4),
        'updated_at' => now()->subYears(4),
    ])->saveQuietly();

    $this->artisan('contact-messages:prune', ['--dry-run' => true])->assertSuccessful();

    expect(ContactMessage::find($message->id))->not->toBeNull();
});
