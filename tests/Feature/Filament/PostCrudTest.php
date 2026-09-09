<?php

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('lists posts', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['title' => 'Article visible']);

    Livewire::actingAs($user)
        ->test(ListPosts::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$post]);
});

it('creates a draft post', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePost::class)
        ->fillForm([
            'title' => 'Nouvel article',
            'slug' => 'nouvel-article',
            'excerpt' => 'Un court extrait.',
            'content' => '<p>Contenu complet de l’article.</p>',
            'status' => Post::STATUS_DRAFT,
            'user_id' => $user->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $post = Post::where('slug', 'nouvel-article')->first();

    expect($post)->not->toBeNull()
        ->and($post->title)->toBe('Nouvel article')
        ->and($post->status)->toBe(Post::STATUS_DRAFT)
        ->and($post->published_at)->toBeNull();
});

it('publishes a post and sets the published date automatically', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePost::class)
        ->fillForm([
            'title' => 'Article publié',
            'slug' => 'article-publie',
            'content' => '<p>Contenu.</p>',
            'status' => Post::STATUS_PUBLISHED,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $post = Post::where('slug', 'article-publie')->first();

    expect($post)->not->toBeNull()
        ->and($post->status)->toBe(Post::STATUS_PUBLISHED)
        ->and($post->published_at)->not->toBeNull();
});

it('rejects a duplicate slug', function () {
    $user = User::factory()->create();
    Post::factory()->create(['slug' => 'slug-utilise']);

    Livewire::actingAs($user)
        ->test(CreatePost::class)
        ->fillForm([
            'title' => 'Doublon',
            'slug' => 'slug-utilise',
            'status' => Post::STATUS_DRAFT,
        ])
        ->call('create')
        ->assertHasFormErrors(['slug']);
});

it('updates a post and republishes it', function () {
    $user = User::factory()->create();
    $post = Post::factory()->draft()->create(['title' => 'Ancien titre']);

    Livewire::actingAs($user)
        ->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm([
            'title' => 'Titre modifié',
            'slug' => 'titre-modifie',
            'excerpt' => 'Nouvel extrait.',
            'content' => '<p>Nouveau contenu.</p>',
            'status' => Post::STATUS_PUBLISHED,
            'user_id' => $user->id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $post->refresh();

    expect($post->title)->toBe('Titre modifié')
        ->and($post->slug)->toBe('titre-modifie')
        ->and($post->status)->toBe(Post::STATUS_PUBLISHED)
        ->and($post->published_at)->not->toBeNull();
});

it('deletes a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    Livewire::actingAs($user)
        ->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->callAction('delete');

    expect(Post::find($post->id))->toBeNull();
});
