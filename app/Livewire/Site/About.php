<?php

namespace App\Livewire\Site;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('À propos — Sena Studio')]
#[Layout('layouts.public')]
class About extends Component
{
    public function mount(): void
    {
        app(Seo::class)->set(
            title: null,
            description: 'Studio indépendant : conception de produits web, applications et solutions sur mesure, de l’idée à la mise en production.',
            canonical: localized_route('about'),
        );
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'projects' => Project::query()->where('visibility', 'public')->where('status', '!=', 'cancelled')->count(),
            'skills' => Skill::query()->where('is_active', true)->count(),
            'testimonials' => Testimonial::query()->visible()->count(),
        ];
    }

    #[Computed]
    public function testimonials()
    {
        return Testimonial::query()->visible()->take(6)->get();
    }

    public function render()
    {
        return view('pages.public.about');
    }
}
