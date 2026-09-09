<?php

namespace App\Livewire\Site;

use App\Models\Project;
use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Projet — Sena Studio')]
#[Layout('layouts.public')]
class ProjectDetail extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        abort_unless($project->visibility->value === 'public' && $project->status->value !== 'cancelled', 404);

        $this->project = $project->load(['stack.stackItems', 'skills', 'categories', 'infra']);

        app(Seo::class)->set(
            title: $project->name,
            description: $project->description ? str($project->description)->limit(160) : null,
            canonical: url()->route('projects.show', $project),
            type: 'website',
            image: $project->image ? asset($project->image) : null,
        );
    }

    public function render()
    {
        return view('pages.public.project-detail');
    }
}
