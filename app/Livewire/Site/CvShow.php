<?php

namespace App\Livewire\Site;

use App\Models\Cv;
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
    }

    public function render(): View
    {
        return view('pages.public.cv-show');
    }
}
