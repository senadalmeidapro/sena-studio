<?php

use App\Livewire\Site\About;
use App\Livewire\Site\BlogIndex;
use App\Livewire\Site\BlogShow;
use App\Livewire\Site\Contact;
use App\Livewire\Site\CvShow;
use App\Livewire\Site\Home;
use App\Livewire\Site\ProjectDetail;
use App\Livewire\Site\Projects;
use App\Livewire\Site\Skills;
use App\Livewire\Site\Stack;
use App\Models\Cv;
use App\Models\Post;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', Home::class)->name('home');
Route::get('projets', Projects::class)->name('projects.index');
Route::get('projets/{project:slug}', ProjectDetail::class)->name('projects.show');
Route::get('competences', Skills::class)->name('skills.index');
Route::get('stack', Stack::class)->name('stack.index');
Route::get('a-propos', About::class)->name('about');
Route::get('blog', BlogIndex::class)->name('posts.index');
Route::get('blog/{post:slug}', BlogShow::class)->name('posts.show');
Route::get('contact', Contact::class)->name('contact');
Route::get('cv/{cv:slug}', CvShow::class)->name('cv.show');

Route::get('robots.txt', function () {
    $disallow = app()->isProduction() ? '' : "Disallow: /\n";

    return response("User-agent: *\n{$disallow}Allow: /\n\nSitemap: ".url('sitemap.xml')."\n")
        ->header('Content-Type', 'text/plain');
});

Route::get('sitemap.xml', function () {
    $urls = [url('/'), url('projets'), url('competences'), url('stack'), url('a-propos'), url('blog'), url('contact')];

    foreach (Project::query()->where('visibility', 'public')->where('status', '!=', 'cancelled')->pluck('slug') as $slug) {
        $urls[] = url('projets/'.$slug);
    }

    foreach (Cv::primary()->pluck('slug') as $slug) {
        $urls[] = url('cv/'.$slug);
    }

    foreach (Post::query()->published()->pluck('slug') as $slug) {
        $urls[] = url('blog/'.$slug);
    }

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

    foreach ($urls as $url) {
        $xml .= "  <url>\n    <loc>".e($url)."</loc>\n  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml)->header('Content-Type', 'application/xml');
})->name('sitemap');

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
