<?php

namespace App\Livewire\Site;

use App\Models\Project;
use App\Models\Skill;
use App\Models\StackItem;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Studio — Développement web sur mesure')]
#[Layout('layouts.public')]
class Home extends Component
{
    public function mount(): void
    {
        app(Seo::class)->set(
            description: 'Studio indépendant : conception de produits web, applications et solutions sur mesure — Laravel, Livewire et Filament.',
            canonical: localized_route('home'),
            structuredData: [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'WebSite',
                        'name' => config('app.name'),
                        'url' => localized_route('home'),
                        'description' => 'Conception de produits web, applications et solutions logicielles sur mesure.',
                    ],
                    [
                        '@type' => 'Person',
                        'name' => config('app.name'),
                        'url' => localized_route('home'),
                        'jobTitle' => 'Software Engineer',
                        'knowsAbout' => [
                            'Backend engineering',
                            'API design',
                            'Software architecture',
                            'DevOps',
                        ],
                    ],
                ],
            ],
        );
    }

    #[Computed]
    public function featuredProjects()
    {
        return Project::query()
            ->where('visibility', 'public')
            ->where('status', '!=', 'cancelled')
            ->with(['stack.stackItems', 'skills'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->latest('started_at')
            ->limit(3)
            ->get();
    }

    #[Computed]
    public function topSkills()
    {
        $order = ['expert' => 0, 'advanced' => 1, 'intermediate' => 2, 'beginner' => 3];

        return Skill::query()
            ->where('is_active', true)
            ->get()
            ->sortBy(fn ($skill) => $order[$skill->level->value] ?? 9)
            ->take(8)
            ->values();
    }

    #[Computed]
    public function projectCount()
    {
        return Project::query()->where('visibility', 'public')->count();
    }

    #[Computed]
    public function stackHighlights()
    {
        return StackItem::query()
            ->with('stack')
            ->whereHas('stack', fn ($q) => $q->where('is_active', true))
            ->whereIn('category', ['frontend', 'backend', 'database', 'devops'])
            ->get()
            ->groupBy('category');
    }

    public function render()
    {
        return view('pages.public.home');
    }
}
