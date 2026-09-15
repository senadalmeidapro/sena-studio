<?php

namespace App\Livewire\Site;

use App\Models\Post;
use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class BlogShow extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        abort_unless($post->isPublished(), 404);

        $this->post = $post->load(['categories', 'author']);

        app(Seo::class)->set(
            title: trim($post->seo_title ?: $post->title),
            description: $post->seo_description ?: str($post->excerpt ?: $post->content)->stripTags()->limit(160),
            canonical: localized_route('posts.show', $post),
            type: 'article',
            image: media_url($post->cover_image),
            structuredData: [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $post->seo_title ?: $post->title,
                'description' => $post->seo_description ?: str($post->excerpt ?: $post->content)->stripTags()->limit(160),
                'datePublished' => $post->published_at?->toAtomString(),
                'dateModified' => $post->updated_at?->toAtomString(),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => localized_route('posts.show', $post),
                ],
                'author' => [
                    '@type' => 'Person',
                    'name' => $post->author?->name ?? 'Sena Studio',
                ],
                'image' => media_url($post->cover_image) ?? asset('/images/brand/sena-mark.svg'),
            ],
        );
    }

    public function title(): string
    {
        return ($this->post->seo_title ?: $this->post->title).' — Sena Studio';
    }

    public function render()
    {
        return view('pages.public.blog.show');
    }
}
