<?php

namespace App\Livewire\Site;

use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Data handling — Sena Studio')]
#[Layout('layouts.public')]
class DataHandling extends Component
{
    public function mount(Seo $seo): void
    {
        $seo->set(
            title: __('data_handling.title'),
            description: __('data_handling.subtitle'),
            canonical: localized_route('data-handling'),
        );
    }

    public function render()
    {
        return view('pages.public.data-handling');
    }
}
