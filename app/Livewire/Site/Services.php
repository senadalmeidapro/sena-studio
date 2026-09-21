<?php

namespace App\Livewire\Site;

use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Services — Sena Studio')]
class Services extends Component
{
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
