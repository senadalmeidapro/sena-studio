<?php

use App\Livewire\Site\Contact;
use App\Livewire\Site\CvShow;
use App\Livewire\Site\Home;
use App\Livewire\Site\ProjectDetail;
use App\Livewire\Site\Projects;
use App\Livewire\Site\Skills;
use App\Livewire\Site\Stack;
use App\Models\Cv;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', Home::class)->name('home');
Route::get('projets', Projects::class)->name('projects.index');
Route::get('projets/{project:slug}', ProjectDetail::class)->name('projects.show');
Route::get('competences', Skills::class)->name('skills.index');
Route::get('stack', Stack::class)->name('stack.index');
Route::get('contact', Contact::class)->name('contact');
Route::get('cv/{cv:slug}', CvShow::class)->name('cv.show');

Route::middleware(['auth', 'verified'])->get('/admin/cvs/{cv}/pdf', function (Cv $cv) {
    $html = View::make('pdf.cv', ['cv' => $cv])->render();

    $file = Pdf::loadHTML($html);
    $file->setPaper('a4');
    $file->setOptions([
        'isRemoteEnabled' => false,
        'isHtml5ParserEnabled' => true,
    ]);

    $name = 'CV-'.str_replace(' ', '-', trim((string) ($cv->version_label ?? $cv->headline ?? 'sena-studio'))).'.pdf';

    return $file->download($name);
})->name('admin.cvs.pdf');

require __DIR__.'/settings.php';
