<?php

namespace App\Livewire\Site;

use App\Enums\ProjectType;
use App\Models\Project;
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

    protected $queryString = ['type'];

    public function filterBy(?string $type): void
    {
        $this->type = $type;
        $this->resetPage();
    }

    #[Computed]
    public function projects()
    {
        return Project::query()
            ->where('visibility', 'public')
            ->where('status', '!=', 'cancelled')
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
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

    public function render()
    {
        return view('pages.public.projects');
    }
}
