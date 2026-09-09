<?php

namespace App\Livewire\Site;

use App\Models\Stack as StackModel;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Stack technique — Sena Studio')]
#[Layout('layouts.public')]
class Stack extends Component
{
    public function mount(): void
    {
        app(Seo::class)->set(
            title: 'Stack technique',
            description: 'L’environnement technique de Sena Studio : outils, langages et services utilisés pour livrer des produits fiables.',
            canonical: url()->route('stack.index'),
        );
    }

    #[Computed]
    public function stacks()
    {
        return StackModel::query()
            ->where('is_active', true)
            ->with(['stackItems', 'projects' => fn ($q) => $q->where('visibility', 'public')->where('status', '!=', 'cancelled')])
            ->get();
    }

    public function render()
    {
        return view('pages.public.stack');
    }
}
