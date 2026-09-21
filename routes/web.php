<?php

use App\Livewire\Site\About;
use App\Livewire\Site\BlogIndex;
use App\Livewire\Site\BlogShow;
use App\Livewire\Site\Contact;
use App\Livewire\Site\CvShow;
use App\Livewire\Site\Home;
use App\Livewire\Site\LegalNotice;
use App\Livewire\Site\PostPreview;
use App\Livewire\Site\Privacy;
use App\Livewire\Site\ProjectDetail;
use App\Livewire\Site\Projects;
use App\Livewire\Site\Services;
use App\Livewire\Site\Skills;
use App\Models\Cv;
use App\Models\Post;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::prefix('{locale?}')
    ->whereIn('locale', ['fr', 'en'])
    ->group(function () {
        Route::get('/', Home::class)->name('home');
        Route::get('projets', Projects::class)->name('projects.index');
        Route::get('projets/{project:slug}', ProjectDetail::class)->name('projects.show');
        Route::get('competences', Skills::class)->name('skills.index');
        Route::get('services', Services::class)->name('services');
        Route::get('stack', fn () => redirect(localized_route('skills.index'), 301))->name('stack.index');
        Route::get('a-propos', About::class)->name('about');
        Route::get('blog', BlogIndex::class)->name('posts.index');
        Route::get('blog/{post:slug}', BlogShow::class)->name('posts.show');
        Route::get('blog/{post:slug}/preview', PostPreview::class)
            ->middleware('signed')
            ->name('posts.preview');
        Route::get('contact', Contact::class)->name('contact');
        Route::get('mentions-legales', LegalNotice::class)->name('legal.notice');
        Route::get('confidentialite', Privacy::class)->name('legal.privacy');
        Route::get('cv/{cv:slug}', CvShow::class)->name('cv.show');
    });

Route::get('robots.txt', function () {
    $disallow = app()->isProduction() ? '' : "Disallow: /\n";

    return response("User-agent: *\n{$disallow}Allow: /\n\nSitemap: ".url('sitemap.xml')."\n")
        ->header('Content-Type', 'text/plain');
});

Route::get('sitemap.xml', function () {
    $urls = [];

    foreach (['fr', 'en'] as $locale) {
        $prefix = '/'.$locale;

        $urls[] = [$prefix, now()->toAtomString()];
        $urls[] = [$prefix.'/projets', now()->toAtomString()];
        $urls[] = [$prefix.'/competences', now()->toAtomString()];
        $urls[] = [$prefix.'/services', now()->toAtomString()];
        $urls[] = [$prefix.'/a-propos', now()->toAtomString()];
        $urls[] = [$prefix.'/blog', now()->toAtomString()];
        $urls[] = [$prefix.'/contact', now()->toAtomString()];

        foreach (Project::query()->where('visibility', 'public')->where('status', '!=', 'cancelled')->where('slug', '!=', 'portfolio-sena-studio')->get(['slug', 'updated_at']) as $project) {
            $urls[] = [$prefix.'/projets/'.$project->slug, $project->updated_at?->toAtomString()];
        }

        foreach (Cv::published()->primary()->get('slug') as $cv) {
            $urls[] = [$prefix.'/cv/'.$cv->slug, now()->toAtomString()];
        }

        foreach (Post::query()->published()->get(['slug', 'updated_at']) as $post) {
            $urls[] = [$prefix.'/blog/'.$post->slug, $post->updated_at?->toAtomString()];
        }
    }

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

    foreach ($urls as [$loc, $lastmod]) {
        $xml .= "  <url>\n    <loc>".e(url($loc))."</loc>\n    <lastmod>{$lastmod}</lastmod>\n  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::fallback(function () {
    $path = trim(request()->path(), '/');

    $legacy = preg_match('#^(?:projets|competences|stack|a-propos|blog|contact|cv)(?:/[^/]+)?$#', $path);

    if ($path === '' || $legacy) {
        return redirect('/'.app()->getLocale().'/'.$path, 301);
    }

    abort(404);
})->name('fallback');

Route::middleware(['auth', 'verified'])->get('/admin/cvs/{cv}/pdf', function (Request $request, Cv $cv) {
    abort_unless($request->user()?->isAdmin(), 403);

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
