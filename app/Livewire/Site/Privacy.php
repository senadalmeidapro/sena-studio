<?php

namespace App\Livewire\Site;

use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Confidentialité — Sena Studio')]
class Privacy extends Component
{
    public function mount(Seo $seo): void
    {
        $seo->set(title: __('legal.privacy_title'), description: __('legal.privacy_description'), canonical: localized_route('legal.privacy'));
    }

    public function render()
    {
        return view('pages.public.privacy');
    }
}
