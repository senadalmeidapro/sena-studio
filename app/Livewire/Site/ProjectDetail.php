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
        $isProtectedShareRoute = request()->routeIs('projects.protected');
        $isSharedProtectedProject = $isProtectedShareRoute
            && $project->visibility === ProjectVisibility::Protected
            && filled($project->share_token)
            && is_string(request()->query('token'))
            && hash_equals($project->share_token, request()->query('token'));
        $isPublished = $project->status !== ProjectStatus::Cancelled;
        $isPublicProject = ! $isProtectedShareRoute
            && $project->visibility === ProjectVisibility::Public;

        abort_unless(
            $isPublished && ($isPublicProject || $isSharedProtectedProject),
            404,
        );

        $this->project = $project->load(['skills', 'categories', 'projectImages', 'testimonial']);

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
