<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
