<?php

use App\Enums\ProjectVisibility;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it('does not expose a future-dated published post', function () {
    $post = Post::factory()->create([
        'status' => Post::STATUS_PUBLISHED,
        'published_at' => now()->addDay(),
    ]);

    $this->get(route('posts.show', [
        'locale' => 'fr',
        'post' => $post->slug,
    ]))->assertNotFound();
});

it('allows a temporary signed preview for an unpublished post', function () {
    $post = Post::factory()->draft()->create([
        'title' => 'Brouillon en aperçu',
    ]);

    $previewUrl = URL::temporarySignedRoute(
        'posts.preview',
        now()->addMinutes(10),
        ['locale' => 'fr', 'post' => $post->slug],
    );

    $this->get($previewUrl)
        ->assertOk()
        ->assertSee('Aperçu privé')
        ->assertSee('noindex, nofollow, noarchive');

    $this->get(route('posts.preview', [
        'locale' => 'fr',
        'post' => $post->slug,
    ]))->assertForbidden();
});

it('allows a signed link to show a protected project while blocking its public URL', function () {
    $project = Project::factory()->create([
        'slug' => 'protected-project',
        'visibility' => ProjectVisibility::Protected,
        'status' => 'production',
    ]);

    $this->get(localized_route('projects.show', $project))
        ->assertNotFound();

    $shareUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en',
        'project' => $project->slug,
    ]);

    $this->get($shareUrl)
        ->assertOk()
        ->assertSee($project->name)
        ->assertSee('noindex, nofollow');
});

it('does not expose private projects through signed share links', function () {
    $project = Project::factory()->create([
        'visibility' => ProjectVisibility::Private,
        'status' => 'production',
    ]);

    $shareUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en',
        'project' => $project->slug,
    ]);

    $this->get($shareUrl)->assertNotFound();
});
