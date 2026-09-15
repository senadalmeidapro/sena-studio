<?php

use App\Models\Post;
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
