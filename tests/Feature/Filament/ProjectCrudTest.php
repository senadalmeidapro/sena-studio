<?php

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('validates and saves case study fields in the project admin form', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(CreateProject::class)
        ->fillForm([
            'name' => 'Case study admin project',
            'slug' => 'case-study-admin-project',
            'outcome_type' => 'not-an-outcome',
            'projectImages' => [],
        ])
        ->call('create')
        ->assertHasFormErrors(['outcome_type']);

    Livewire::actingAs($admin)
        ->test(CreateProject::class)
        ->fillForm([
            'name' => 'Case study admin project',
            'slug' => 'case-study-admin-project',
            'role' => 'Backend engineer',
            'problem' => 'A workflow needed simplification.',
            'constraints' => 'Limited connectivity.',
            'architecture' => 'A modular API.',
            'technical_decisions' => 'Queue external work.',
            'result' => 'The new workflow was delivered.',
            'client_context' => 'Anonymous client context',
            'outcome_type' => 'delivered',
            'projectImages' => [],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $project = Project::query()->where('slug', 'case-study-admin-project')->firstOrFail();

    expect($project->constraints)->toBe('Limited connectivity.')
        ->and($project->client_context)->toBe('Anonymous client context')
        ->and($project->outcome_type->value)->toBe('delivered');
});

it('filters public projects with an incomplete core case study', function () {
    $admin = User::factory()->admin()->create();
    $incompletePublicProject = Project::factory()->create([
        'visibility' => 'public',
        'role' => 'Backend engineer',
        'problem' => 'A problem statement.',
    ]);
    $completePublicProject = Project::factory()->create([
        'visibility' => 'public',
        'role' => 'Backend engineer',
        'problem' => 'A problem statement.',
        'architecture' => 'An API architecture.',
        'technical_decisions' => 'Idempotent requests.',
        'result' => 'A verified outcome.',
    ]);
    $privateIncompleteProject = Project::factory()->create([
        'visibility' => 'private',
    ]);

    Livewire::actingAs($admin)
        ->test(ListProjects::class)
        ->assertTableColumnExists('case_study_completeness')
        ->filterTable('public_projects_with_incomplete_case_study', true)
        ->assertCanSeeTableRecords([$incompletePublicProject])
        ->assertCanNotSeeTableRecords([$completePublicProject, $privateIncompleteProject]);
});
