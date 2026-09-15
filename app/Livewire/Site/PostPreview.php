<?php

namespace App\Livewire\Site;

use App\Models\Post;
use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PostPreview extends Component
{
    public Post $post;

    public bool $preview = true;

    public function mount(Post $post): void
    {
        $this->post = $post->load(['categories', 'author']);

        app(Seo::class)->set(
            title: trim($post->seo_title ?: $post->title).' — Aperçu',
            description: $post->seo_description ?: str($post->excerpt ?: $post->content)->stripTags()->limit(160),
            canonical: localized_route('posts.show', $post),
            type: 'article',
            image: media_url($post->cover_image),
            robots: 'noindex, nofollow, noarchive',
        );
    }

    public function title(): string
    {
        return ($this->post->seo_title ?: $this->post->title).' — Aperçu — Sena Studio';
    }

    public function render()
    {
        return view('pages.public.blog.show');
    }
}
