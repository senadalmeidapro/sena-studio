<?php

use App\Filament\Resources\Messages\ContactMessageResource;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders admin dashboard and resources', function () {
    $user = User::factory()->create();
    $message = ContactMessage::create([
        'name' => 'Test',
        'email' => 'test@example.com',
        'subject' => 'Sujet',
        'message' => 'Un message de test suffisamment long pour être valide.',
    ]);

    $paths = [
        '/admin',
        '/admin/projects',
        '/admin/projects/create',
        '/admin/skills',
        '/admin/stacks',
        '/admin/stacks/create',
        ContactMessageResource::getUrl('index'),
        ContactMessageResource::getUrl('view', ['record' => $message]),
    ];

    foreach ($paths as $path) {
        $this->actingAs($user)->get($path)->assertSuccessful();
    }
});

it('marks contact message as read when viewed', function () {
    $user = User::factory()->create();
    $message = ContactMessage::create([
        'name' => 'Test',
        'email' => 'test@example.com',
        'subject' => 'Sujet',
        'message' => 'Un message de test suffisamment long pour être valide.',
    ]);

    expect($message->isRead())->toBeFalse();

    $this->actingAs($user)->get(ContactMessageResource::getUrl('view', ['record' => $message]));

    expect($message->fresh()->isRead())->toBeTrue();
});
