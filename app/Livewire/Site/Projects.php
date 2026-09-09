<?php

namespace App\Livewire\Site;

use App\Enums\ProjectType;
use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Services\Seo;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Projets — Sena Studio')]
#[Layout('layouts.public')]
class Projects extends Component
{
    use WithPagination;

    public ?string $type = null;

    public ?string $category = null;

    public ?string $skill = null;

    protected $queryString = ['type', 'category', 'skill'];

    public function mount(): void
    {
        app(Seo::class)->set(
            title: 'Projets',
            description: 'Portfolio de Sena Studio : applications web, SaaS et solutions logicielles, avec les technologies mobilisées.',
            canonical: url()->route('projects.index'),
        );
    }

    public function filterBy(?string $type): void
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function filterByCategory(?string $slug): void
    {
        $this->category = $slug;
        $this->resetPage();
    }

    public function filterBySkill(?string $slug): void
    {
        $this->skill = $slug;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->type = null;
        $this->category = null;
        $this->skill = null;
        $this->resetPage();
    }

    #[Computed]
    public function projects()
    {
        return Project::query()
            ->where('visibility', 'public')
            ->where('status', '!=', 'cancelled')
            ->when($this->type, fn (Builder $q) => $q->where('type', $this->type))
            ->when($this->category, fn (Builder $q) => $q->whereHas('categories', fn (Builder $c) => $c->where('categories.slug', $this->category)))
            ->when($this->skill, fn (Builder $q) => $q->whereHas('skills', fn (Builder $s) => $s->where('skills.slug', $this->skill)))
            ->with(['stack.stackItems', 'skills', 'categories'])
            ->orderByDesc('ended_at')
            ->orderByDesc('started_at')
            ->paginate(9);
    }

    #[Computed]
    public function counts()
    {
        return [
            'all' => Project::query()->where('visibility', 'public')->where('status', '!=', 'cancelled')->count(),
            'web' => Project::query()->where('visibility', 'public')->where('type', ProjectType::Web)->count(),
            'app' => Project::query()->where('visibility', 'public')->where('type', ProjectType::App)->count(),
            'software' => Project::query()->where('visibility', 'public')->where('type', ProjectType::Software)->count(),
        ];
    }

    #[Computed]
    public function categories()
    {
        return Category::query()
            ->withCount(['projects' => fn (Builder $q) => $q->where('visibility', 'public')->where('status', '!=', 'cancelled')])
            ->get()
            ->filter(fn (Category $category): bool => $category->projects_count > 0)
            ->values()
            ->sortBy(fn (Category $category): int => -$category->projects_count)
            ->values();
    }

    #[Computed]
    public function skills()
    {
        return Skill::query()
            ->where('is_active', true)
            ->whereHas('projects', fn (Builder $q) => $q->where('projects.visibility', 'public')->where('projects.status', '!=', 'cancelled'))
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('pages.public.projects');
    }
}
