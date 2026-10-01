<?php

use App\Enums\ProjectVisibility;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('creates the current signed share link from the project table', function () {
    $project = Project::factory()->create([
        'slug' => 'generated-share-project',
        'visibility' => ProjectVisibility::Protected,
        'status' => 'production',
    ]);

    $projectsTable = Livewire::actingAs(User::factory()->admin()->create())
        ->test(ListProjects::class)
        ->assertTableActionExists('protectedShareLink', record: $project);

    $project->refresh();
    expect($project->share_token)->toBeString()->not->toBeEmpty();

    $projectsTable->assertTableActionHasUrl(
        'protectedShareLink',
        URL::signedRoute('projects.protected', [
            'locale' => app()->getLocale(),
            'project' => $project->slug,
            'token' => $project->share_token,
        ]),
        $project,
    );
});

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
    $project->forceFill(['share_token' => Str::random(64)])->save();

    $this->get(localized_route('projects.show', $project))
        ->assertNotFound();

    $shareUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en',
        'project' => $project->slug,
        'token' => $project->share_token,
    ]);

    $this->get($shareUrl)
        ->assertOk()
        ->assertSee($project->name)
        ->assertSee('noindex, nofollow');
});

it('rejects protected project links with a missing or incorrect share token', function () {
    $project = Project::factory()->create([
        'slug' => 'token-required-project',
        'visibility' => ProjectVisibility::Protected,
        'status' => 'production',
    ]);
    $project->forceFill(['share_token' => Str::random(64)])->save();

    foreach ([null, 'wrong-token'] as $token) {
        $parameters = ['locale' => 'en', 'project' => $project->slug];

        if ($token !== null) {
            $parameters['token'] = $token;
        }

        $this->get(URL::signedRoute('projects.protected', $parameters))->assertNotFound();
    }
});

it('revokes a protected project link when the admin regenerates its token', function () {
    $project = Project::factory()->create([
        'slug' => 'rotatable-project',
        'visibility' => ProjectVisibility::Protected,
        'status' => 'production',
    ]);
    $project->forceFill(['share_token' => Str::random(64)])->save();
    $oldUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en', 'project' => $project->slug, 'token' => $project->share_token,
    ]);

    Livewire::actingAs(User::factory()->admin()->create())
        ->test(ListProjects::class)
        ->callTableAction('regenerateShareLink', $project)
        ->assertHasNoTableActionErrors();

    expect($project->fresh()->share_token)->not->toBe($project->share_token);
    $this->get($oldUrl)->assertNotFound();
});

it('rejects a protected share link after the project becomes public', function () {
    $project = Project::factory()->create([
        'slug' => 'visibility-changed-project',
        'visibility' => ProjectVisibility::Protected,
        'status' => 'production',
    ]);
    $project->forceFill(['share_token' => Str::random(64)])->save();
    $oldUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en', 'project' => $project->slug, 'token' => $project->share_token,
    ]);
    $project->update(['visibility' => ProjectVisibility::Public]);

    $this->get($oldUrl)->assertNotFound();
});

it('does not expose private projects through signed share links', function () {
    $project = Project::factory()->create([
        'visibility' => ProjectVisibility::Private,
        'status' => 'production',
    ]);

    $shareUrl = URL::signedRoute('projects.protected', [
        'locale' => 'en',
        'project' => $project->slug,
        'token' => 'irrelevant',
    ]);

    $this->get($shareUrl)->assertNotFound();
});
