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

        $this->project = $project->load(['stack.stackItems', 'skills', 'categories', 'infra', 'projectImages']);

        app(Seo::class)->set(
            title: $project->name,
            description: $project->description ? str($project->description)->limit(160) : null,
            canonical: localized_route('projects.show', $project),
            type: 'website',
            image: media_url($project->image),
            structuredData: [
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareSourceCode',
                'name' => $project->name,
                'description' => $project->description,
                'url' => localized_route('projects.show', $project),
                'codeRepository' => $project->repository_url,
                'image' => media_url($project->image) ?? asset('/images/brand/sena-mark.svg'),
                'programmingLanguage' => $project->skills->pluck('name')->values()->all(),
            ],
        );
    }

    public function render()
    {
        return view('pages.public.project-detail');
    }
}
