<?php

namespace App\Livewire\Site;

use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Mentions légales — Sena Studio')]
class LegalNotice extends Component
{
    public function mount(Seo $seo): void
    {
        $seo->set(title: __('legal.notice_title'), description: __('legal.notice_description'), canonical: localized_route('legal.notice'));
    }

    public function render()
    {
        return view('pages.public.legal-notice');
    }
}
