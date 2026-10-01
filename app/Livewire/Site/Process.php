<?php

namespace App\Livewire\Site;

use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('How I work — Sena Studio')]
#[Layout('layouts.public')]
class Process extends Component
{
    public function mount(Seo $seo): void
    {
        $seo->set(
            title: __('process.title'),
            description: __('process.subtitle'),
            canonical: localized_route('process'),
        );
    }

    public function render()
    {
        return view('pages.public.process');
    }
}
