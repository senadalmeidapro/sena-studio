<?php

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\ContactPipelineWidget;
use App\Filament\Widgets\NewLeadsWidget;
use App\Filament\Widgets\ProjectsMissingMediaWidget;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('limits the dashboard to the three phase 3 action widgets', function () {
    expect((new Dashboard)->getWidgets())->toBe([
        NewLeadsWidget::class,
        ContactPipelineWidget::class,
        ProjectsMissingMediaWidget::class,
    ]);
});

it('shows unread leads and excludes messages already read', function () {
    $unread = ContactMessage::create([
        'name' => 'Unread lead',
        'email' => 'unread@example.test',
        'subject' => 'New project',
        'message' => 'A request that needs a response.',
    ]);
    $read = ContactMessage::create([
        'name' => 'Read lead',
        'email' => 'read@example.test',
        'subject' => 'Answered project',
        'message' => 'A request that has already been read.',
    ]);
    $read->markAsRead();

    $data = (new NewLeadsWidget)->getViewData();

    expect($data['messages']->modelKeys())
        ->toContain($unread->id)
        ->not->toContain($read->id);
});

it('lists projects only when they have no cover or gallery media', function () {
    $missingMedia = Project::factory()->create([
        'image' => null,
        'slug' => 'missing-media-project',
        'status' => 'production',
        'visibility' => 'public',
    ]);
    $hasCover = Project::factory()->create([
        'image' => 'images/screenshots/cover.svg',
        'slug' => 'cover-only-project',
        'status' => 'production',
        'visibility' => 'public',
    ]);

    $data = (new ProjectsMissingMediaWidget)->getViewData();

    expect($data['projects']->modelKeys())
        ->toContain($missingMedia->id)
        ->not->toContain($hasCover->id);
});
