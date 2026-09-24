<?php

namespace App\Livewire\Site;

use App\Models\Project;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Services — Sena Studio')]
class Services extends Component
{
    #[Computed]
    public function proofProjects()
    {
        $projects = Project::query()
            ->where('visibility', 'public')
            ->where('status', '!=', 'cancelled')
            ->whereIn('slug', ['mini-shop', 'itdesk', 'mini-shop-api', 'api-orientation'])
            ->get()
            ->keyBy('slug');

        return collect([
            'web' => ['mini-shop'],
            'operations' => ['itdesk'],
            'apis' => ['mini-shop-api', 'api-orientation'],
            'evolution' => ['itdesk', 'mini-shop-api'],
        ])->map(fn (array $slugs) => collect($slugs)->map(fn (string $slug) => $projects->get($slug))->filter()->values());
    }

    public function mount(Seo $seo): void
    {
        $seo->set(
            title: __('nav.services'),
            description: app()->getLocale() === 'en'
                ? 'Backend engineering services for APIs, business applications, back-offices and technical evolution.'
                : 'Services d’ingénierie backend pour APIs, applications métier, back-offices et évolution technique.',
            canonical: localized_route('services'),
        );
    }

    public function render()
    {
        return view('pages.public.services');
    }
}
