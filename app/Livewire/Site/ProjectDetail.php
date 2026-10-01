<?php

namespace App\Livewire\Site;

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
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
        $isSharedProtectedProject = request()->routeIs('projects.protected')
            && $project->visibility === ProjectVisibility::Protected;
        $isPublished = $project->status !== ProjectStatus::Cancelled;

        abort_unless(
            $isPublished && ($project->visibility === ProjectVisibility::Public || $isSharedProtectedProject),
            404,
        );

        $this->project = $project->load(['skills', 'categories', 'projectImages']);

        $seo = app(Seo::class)->set(
            title: $project->name,
            description: $project->description ? str($project->description)->limit(160) : null,
            type: 'website',
            image: media_url($project->image),
            structuredData: $isSharedProtectedProject ? [] : [
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

        if ($isSharedProtectedProject) {
            $seo->set(robots: 'noindex, nofollow');
        } else {
            $seo->set(canonical: localized_route('projects.show', $project));
        }
    }

    public function render()
    {
        return view('pages.public.project-detail');
    }
}
