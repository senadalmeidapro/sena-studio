<?php

namespace App\Livewire\Site;

use App\Models\Category;
use App\Models\Post;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Blog — Sena Studio')]
#[Layout('layouts.public')]
class BlogIndex extends Component
{
    use WithPagination;

    public ?string $category = null;

    protected $queryString = ['category'];

    public function mount(): void
    {
        app(Seo::class)->set(
            title: 'Blog',
            description: 'Notes sur le développement web : retours d’expérience, bonnes pratiques et coulisses des projets de Sena Studio.',
            canonical: url()->route('posts.index'),
        );
    }

    public function filterByCategory(?string $slug): void
    {
        $this->category = $slug;
        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {
        return Post::query()
            ->published()
            ->with(['categories', 'author'])
            ->when($this->category, fn ($q) => $q->whereHas('categories', fn ($cq) => $cq->where('slug', $this->category)))
            ->orderByDesc('published_at')
            ->paginate(9);
    }

    #[Computed]
    public function categories()
    {
        return Category::query()
            ->whereHas('posts')
            ->withCount('posts')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('pages.public.blog.index');
    }
}
