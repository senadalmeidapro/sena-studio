<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Tableau de bord')]
class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.admin.dashboard', [
            'stats' => [
                'projects' => Project::query()->count(),
                'posts' => Post::query()->count(),
                'messages' => ContactMessage::query()->count(),
                'testimonials' => Testimonial::query()->count(),
            ],
            'recentProjects' => Project::query()->latest()->limit(5)->get(),
        ]);
    }
}
