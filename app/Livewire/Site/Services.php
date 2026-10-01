<?php

namespace App\Livewire\Site;

use App\Models\SiteSetting;
use App\Services\Seo;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Services — Sena Studio')]
class Services extends Component
{
    public ?string $bookingUrl = null;

    public string $availability = 'available';

    public function mount(Seo $seo): void
    {
        $settings = SiteSetting::current();
        $this->bookingUrl = $settings->booking_url;
        $this->availability = $settings->availability;

        $seo->set(
            title: __('nav.services'),
            description: __('services.niche_text'),
            canonical: localized_route('services'),
        );
    }

    public function render()
    {
        return view('pages.public.services');
    }
}
