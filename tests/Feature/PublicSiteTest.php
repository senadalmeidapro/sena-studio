<?php

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
use App\Livewire\Site\Contact;
use App\Livewire\Site\Projects;
use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\StackItem;
use Livewire\Livewire;

test('the home page is accessible and shows featured content', function () {
    Project::factory()->create([
        'name' => 'Projet Public',
        'slug' => 'projet-public',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Sena Studio')
        ->assertSee('Projet Public');
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

    $response = $this->get(route('projects.index'));

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
    $stack = Stack::factory()->create(['is_active' => true]);
    StackItem::factory()->create(['stack_id' => $stack->id, 'category' => 'backend', 'value' => 'Laravel']);
    $skill = Skill::factory()->create(['level' => 'expert']);

    $project = Project::factory()->create([
        'name' => 'Projet Détail',
        'slug' => 'projet-detail',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Production->value,
        'stack_id' => $stack->id,
    ]);
    $project->skills()->attach($skill->id, ['proficiency' => 'primary']);

    $this->get(route('projects.show', 'projet-detail'))
        ->assertOk()
        ->assertSee('Projet Détail')
        ->assertSee('Compétences mobilisées')
        ->assertSee('Laravel');
});

test('a cancelled project detail returns 404', function () {
    Project::factory()->create([
        'name' => 'Projet Annulé',
        'slug' => 'projet-annule',
        'visibility' => ProjectVisibility::Public->value,
        'status' => ProjectStatus::Cancelled->value,
    ]);

    $this->get(route('projects.show', 'projet-annule'))->assertNotFound();
});

test('the skills page shows active skills', function () {
    Skill::factory()->create(['name' => 'PHP', 'is_active' => true, 'level' => 'expert']);

    $this->get(route('skills.index'))
        ->assertOk()
        ->assertSee('PHP');
});

test('the stack page shows stack items grouped by category', function () {
    $stack = Stack::factory()->create(['is_active' => true]);
    StackItem::factory()->create(['stack_id' => $stack->id, 'category' => 'backend', 'value' => 'Laravel']);

    $this->get(route('stack.index'))
        ->assertOk()
        ->assertSee('Laravel');
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
        ->set('subject', 'Demande de projet')
        ->set('message', 'Bonjour, j’aimerais discuter d’un projet avec vous.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('sent', true);
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
