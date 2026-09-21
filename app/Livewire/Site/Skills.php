<?php

namespace App\Livewire\Site;

use App\Models\Skill;
use App\Models\Stack as StackModel;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Compétences — Sena Studio')]
#[Layout('layouts.public')]
class Skills extends Component
{
    public function mount(): void
    {
        app(Seo::class)->set(
            title: 'Compétences',
            description: 'Les technologies et expertises mobilisées par Sena Studio : PHP, Laravel, Livewire, Filament et plus encore.',
            canonical: localized_route('skills.index'),
        );
    }

    #[Computed]
    public function byRole()
    {
        $roles = ['backend', 'frontend', 'database', 'devops', 'other'];

        return Skill::query()
            ->where('is_active', true)
            ->with([
                'categories',
                'projects' => fn ($q) => $q
                    ->where('visibility', 'public')
                    ->where('status', '!=', 'cancelled')
                    ->where('slug', '!=', 'portfolio-sena-studio'),
            ])
            ->get()
            ->groupBy(function ($skill) use ($roles): string {
                foreach ($roles as $role) {
                    if ($role !== 'other' && $skill->categories->contains('slug', $role)) {
                        return $role;
                    }
                }

                return 'other';
            });
    }

    #[Computed]
    public function stacks()
    {
        return StackModel::query()
            ->where('is_active', true)
            ->with(['stackItems', 'projects' => fn ($q) => $q
                ->where('visibility', 'public')
                ->where('status', '!=', 'cancelled')
                ->where('slug', '!=', 'portfolio-sena-studio')])
            ->get();
    }

    public function render()
    {
        return view('pages.public.skills');
    }
}
