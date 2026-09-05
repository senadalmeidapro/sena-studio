<?php

use App\Livewire\Site\Contact;
use App\Livewire\Site\Home;
use App\Livewire\Site\ProjectDetail;
use App\Livewire\Site\Projects;
use App\Livewire\Site\Skills;
use App\Livewire\Site\Stack;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('projets', Projects::class)->name('projects.index');
Route::get('projets/{project:slug}', ProjectDetail::class)->name('projects.show');
Route::get('competences', Skills::class)->name('skills.index');
Route::get('stack', Stack::class)->name('stack.index');
Route::get('contact', Contact::class)->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
