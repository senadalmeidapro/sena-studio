<?php

namespace App\Livewire\Site;

use App\Models\Cv;
use App\Services\Seo;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('CV — Sena Studio')]
#[Layout('layouts.public')]
class CvShow extends Component
{
    public Cv $cv;

    public function mount(Cv $cv): void
    {
        $this->cv = $cv;

        app(Seo::class)->set(
            title: 'CV — '.($cv->version_label ?: 'Sena Studio'),
            description: $cv->headline ?: null,
            canonical: localized_route('cv.show', $cv),
        );
    }

    public function render(): View
    {
        return view('pages.public.cv-show');
    }
}
