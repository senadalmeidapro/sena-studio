<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Projets')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $projectId): void
    {
        Project::query()->findOrFail($projectId)->delete();
        session()->flash('success', 'Le projet a été supprimé.');
    }

    public function render(): View
    {
        return view('livewire.admin.projects.index', [
            'projects' => Project::query()
                ->with('stack')
                ->when($this->search !== '', fn ($query) => $query->where(function ($query): void {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%');
                }))
                ->latest()
                ->paginate(12),
        ]);
    }
}
