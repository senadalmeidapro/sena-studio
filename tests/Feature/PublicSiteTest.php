<?php

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
use App\Livewire\Site\Contact;
use App\Livewire\Site\Projects;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Cv;
use App\Models\Post;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use Livewire\Livewire;

test('the home page is accessible and shows featured content', function () {
    Project::factory()->create([
        'name' => 'Projet Public',
        'slug' => 'projet-public',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);

    $this->get(localized_route('home'))
        ->assertOk()
        ->assertSee('Sena Studio')
        ->assertSee('Projet Public');
});

test('the bare host root redirects to the default localized home', function () {
    $this->get('/')
        ->assertRedirect('/en');
});

test('the bare host root redirects to the language stored in session', function () {
    $this->withSession(['locale' => 'en'])->get('/')
        ->assertRedirect('/en');
});

test('the projects index only shows public projects', function () {
    Project::factory()->create([
        'name' => 'Projet Visible',
        'slug' => 'projet-visible',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);
    Project::factory()->create([
        'name' => 'Projet Privé',
        'slug' => 'projet-prive',
        'visibility' => ProjectVisibility::Private->value,
        'status' => ProjectStatus::Production->value,
    ]);

    $response = $this->get(localized_route('projects.index'));

    $response->assertOk()->assertSee('Projet Visible')->assertDontSee('Projet Privé');
});

test('the projects page filters by type', function () {
    Project::factory()->create([
        'type' => 'web',
        'visibility' => ProjectVisibility::Public->value,
    ]);

    Livewire::test(Projects::class)
        ->set('type', 'web')
        ->assertOk();
});

test('a project detail page shows its relationships', function () {
    $skill = Skill::factory()->create(['name' => 'Laravel', 'category' => 'backend']);

    $project = Project::factory()->create([
        'name' => 'Projet Détail',
        'slug' => 'projet-detail',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);
    $project->skills()->attach($skill->id);

    $this->get(route('projects.show', ['locale' => 'fr', 'project' => 'projet-detail']))
        ->assertOk()
        ->assertSee('Projet Détail')
        ->assertSee('Compétences mobilisées')
        ->assertSee('Laravel');
});

test('a project case study renders context constraints decisions and outcome while hiding absent fields', function () {
    Project::factory()->create([
        'name' => 'Case study project',
        'slug' => 'case-study-project',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
        'role' => 'Backend engineer',
        'problem' => 'Manual reconciliation was slow.',
        'client_context' => 'Anonymous European fintech',
        'constraints' => 'PSD2 integration and strict deadlines.',
        'architecture' => 'An event-driven API.',
        'technical_decisions' => 'Idempotent processing.',
        'result' => 'The workflow was delivered.',
        'outcome_type' => 'delivered',
    ]);

    $this->get('/en/projets/case-study-project')
        ->assertOk()
        ->assertSee(__('project.case_study_context'))
        ->assertSee(__('project.case_study_constraints'))
        ->assertSee(__('project.case_study_decisions'))
        ->assertSee(__('project.case_study_result'))
        ->assertSee('Anonymous European fintech')
        ->assertSee('Delivered');
});

test('an empty case study section is hidden from the public project page', function () {
    Project::factory()->create([
        'slug' => 'empty-case-study-project',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);

    $this->get('/fr/projets/empty-case-study-project')
        ->assertOk()
        ->assertDontSee(__('project.case_study_title'))
        ->assertDontSee(__('project.case_study_constraints'))
        ->assertDontSee(__('project.case_study_client_context'));
});

test('a cancelled project detail returns 404', function () {
    Project::factory()->create([
        'name' => 'Projet Annulé',
        'slug' => 'projet-annule',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Cancelled->value,
    ]);

    $this->get(localized_route('projects.show', 'projet-annule'))->assertNotFound();
});

test('the skills page shows active skills', function () {
    Skill::factory()->create(['name' => 'PHP', 'is_active' => true]);

    $this->get(localized_route('skills.index'))
        ->assertOk()
        ->assertSee('PHP');
});

test('services and legal pages are publicly accessible in both locales', function () {
    $this->get('/fr/services')->assertOk()->assertSee('Services');
    $this->get('/en/services')->assertOk()->assertSee('Services');
    $this->get('/fr/mentions-legales')->assertOk()->assertSee('Mentions');
    $this->get('/en/confidentialite')->assertOk()->assertSee('Privacy');
});

test('all localized public landing routes remain available in French and English', function () {
    $paths = [
        'projets', 'competences', 'services', 'process', 'a-propos', 'blog', 'contact',
        'mentions-legales', 'confidentialite',
    ];

    foreach (['fr', 'en'] as $locale) {
        $this->get('/'.$locale)->assertOk();
        foreach ($paths as $path) {
            $this->get('/'.$locale.'/'.$path)->assertOk();
        }
    }

    $this->get('/')->assertRedirect('/en');
    $this->get('/fr/stack')->assertStatus(301)->assertRedirect('/fr/competences');
    $this->get('/en/stack')->assertStatus(301)->assertRedirect('/en/competences');
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee(url('/fr/process'))
        ->assertSee(url('/en/process'));
});

test('the working process page is localized and linked from services and contact', function () {
    $this->get('/fr/process')->assertOk()->assertSee('Comment je travaille')->assertSee('Cadrage');
    $this->get('/en/process')->assertOk()->assertSee('How I work')->assertSee('Scoping');

    foreach (['/fr', '/en'] as $localePrefix) {
        $this->get($localePrefix.'/services')->assertOk()->assertSee($localePrefix.'/process');
        $this->get($localePrefix.'/contact')->assertOk()->assertSee($localePrefix.'/process');
    }
});

test('published project, post, and CV detail URLs remain available in both locales', function () {
    $project = Project::factory()->create([
        'slug' => 'route-smoke-project',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);
    $posts = [
        'fr' => Post::factory()->create(['slug' => 'route-smoke-post-fr', 'locale' => 'fr']),
        'en' => Post::factory()->create(['slug' => 'route-smoke-post-en', 'locale' => 'en']),
    ];
    $cv = Cv::create([
        'title' => 'Engineering CV', 'version_label' => 'Engineering', 'slug' => 'engineering',
        'status' => 'published', 'is_primary' => true, 'headline' => 'Backend engineer',
    ]);

    foreach (['fr', 'en'] as $locale) {
        $this->get('/'.$locale.'/projets/'.$project->slug)->assertOk();
        $this->get('/'.$locale.'/blog/'.$posts[$locale]->slug)->assertOk();
        $this->get('/'.$locale.'/cv/'.$cv->slug)->assertOk();
    }
});

test('blog content is isolated by locale', function () {
    Post::factory()->count(2)->create(['locale' => 'fr']);
    Post::factory()->count(2)->create(['locale' => 'en']);

    $this->get('/fr/blog')->assertOk();
    $this->get('/en/blog')->assertOk();
});

test('the legacy stack URL redirects to the skills page', function () {
    $this->get(localized_route('stack.index'))
        ->assertStatus(301)
        ->assertRedirect(localized_route('skills.index'));
});

test('the contact form validates input', function () {
    Livewire::test(Contact::class)
        ->set('name', '')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);
});

test('the contact form submits and shows a success message', function () {
    Livewire::test(Contact::class)
        ->set('name', 'Jean Dupont')
        ->set('email', 'jean@exemple.com')
        ->set('project_type', 'fintech_api')
        ->set('goal', 'Automatiser le rapprochement des paiements.')
        ->set('timeline', '1_3_months')
        ->set('budget_range', '1k-5k')
        ->set('message', 'Le système doit s’intégrer à notre banque partenaire.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('sent', true);

    $message = ContactMessage::latest()->first();
    expect($message->project_type)->toBe('fintech_api')
        ->and($message->goal)->toBe('Automatiser le rapprochement des paiements.')
        ->and($message->timeline)->toBe('1_3_months')
        ->and($message->budget_range)->toBe('1k-5k');
});

test('site availability and booking settings appear on public contact and services pages', function () {
    SiteSetting::current()->update(['availability' => 'limited', 'booking_url' => 'https://cal.example.test/sena']);

    $this->get('/en')
        ->assertOk()
        ->assertSee(__('availability.limited'));
    $this->get('/en/contact')
        ->assertOk()
        ->assertSee(__('availability.limited'))
        ->assertSee('https://cal.example.test/sena');
    $this->get('/en/services')
        ->assertOk()
        ->assertSee('fintech and ed-tech')
        ->assertSee('3–6 weeks')
        ->assertSee('https://cal.example.test/sena');
});

test('a public project can show its headline metric and linked visible testimonial', function () {
    $testimonial = Testimonial::factory()->create(['content' => 'Clear delivery and excellent communication.']);
    $project = Project::factory()->create([
        'slug' => 'measured-fintech-project',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
        'result_metric' => '40% faster reconciliation',
        'testimonial_id' => $testimonial->id,
    ]);

    $this->get(localized_route('projects.show', $project->slug))
        ->assertOk()
        ->assertSee('40% faster reconciliation')
        ->assertSee('Clear delivery and excellent communication.');
});

test('the contact honeypot accepts bots silently without storing a lead', function () {
    $before = ContactMessage::count();

    Livewire::test(Contact::class)
        ->set('website', 'https://spam.example.test')
        ->call('submit')
        ->assertSet('sent', true)
        ->assertHasNoErrors();

    expect(ContactMessage::count())->toBe($before);
});

test('the categories relation is used to tag public projects', function () {
    $category = Category::factory()->create(['slug' => 'web']);
    $project = Project::factory()->create([
        'slug' => 'projet-categorie',
        'visibility' => ProjectVisibility::Public->value,
        'type' => 'web',
    ]);
    $project->categories()->attach($category->id);

    expect($project->categories->pluck('slug'))->toContain('web');
});
