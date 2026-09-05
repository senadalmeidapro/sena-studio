<?php

namespace App\Livewire\Site;

use App\Models\Skill;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Compétences — Sena Studio')]
#[Layout('layouts.public')]
class Skills extends Component
{
    #[Computed]
    public function byLevel()
    {
        $order = ['expert' => 0, 'advanced' => 1, 'intermediate' => 2, 'beginner' => 3];

        return Skill::query()
            ->where('is_active', true)
            ->with(['projects' => fn ($q) => $q->where('visibility', 'public')->where('status', '!=', 'cancelled')])
            ->get()
            ->sortBy(fn ($skill) => $order[$skill->level->value] ?? 9)
            ->groupBy('level');
    }

    public function render()
    {
        return view('pages.public.skills');
    }
}
