<?php

namespace App\Livewire\Site;

use App\Models\Post;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class BlogShow extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        abort_unless($post->isPublished() && $post->locale === app()->getLocale(), 404);

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

    #[Computed]
    public function relatedPosts()
    {
        $categoryIds = $this->post->categories->modelKeys();

        if ($categoryIds === []) {
            return collect();
        }

        return Post::query()
            ->published()
            ->where('locale', app()->getLocale())
            ->where($this->post->getKeyName(), '!=', $this->post->getKey())
            ->whereHas('categories', fn ($query) => $query->whereIn('categories.id', $categoryIds))
            ->with(['categories', 'author'])
            ->orderByDesc('published_at')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('pages.public.blog.show');
    }
}
