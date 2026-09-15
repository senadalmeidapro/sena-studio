<?php

use App\Http\Middleware\EnsureAdmin;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Projects\Index as ProjectsIndex;
use App\Livewire\Admin\Projects\ProjectForm;
use App\Livewire\Admin\ResourceIndex;
use Illuminate\Support\Facades\Route;

Route::prefix('backoffice')
    ->name('backoffice.')
    ->middleware(['web', 'auth', 'verified', EnsureAdmin::class])
    ->group(function (): void {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/projects', ProjectsIndex::class)->name('projects.index');
        Route::get('/projects/create', ProjectForm::class)->name('projects.create');
        Route::get('/projects/{project}/edit', ProjectForm::class)->name('projects.edit');
        Route::get('/{resource}', ResourceIndex::class)->whereIn('resource', ['posts', 'cvs', 'skills', 'stacks', 'infras', 'testimonials', 'messages', 'categories'])->name('resource.index');
    });
