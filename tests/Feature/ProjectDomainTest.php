<?php

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
use App\Models\Category;
use App\Models\Infra;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;

it('casts project enum columns to their backed enum classes', function () {
    $project = Project::factory()->create([
        'status' => ProjectStatus::Production->value,
        'visibility' => ProjectVisibility::Public->value,
    ]);

    expect($project->status)->toBeInstanceOf(ProjectStatus::class)
        ->and($project->status)->toBe(ProjectStatus::Production)
        ->and($project->visibility)->toBe(ProjectVisibility::Public);
});

it('belongs to a stack and an infra', function () {
    $stack = Stack::factory()->create();
    $infra = Infra::factory()->create();

    $project = Project::factory()->create([
        'stack_id' => $stack->id,
        'infra_id' => $infra->id,
    ]);

    expect($project->stack->is($stack))->toBeTrue()
        ->and($project->infra->is($infra))->toBeTrue();
});

it('attaches skills with a proficiency pivot value', function () {
    $project = Project::factory()->create();
    $skill = Skill::factory()->create();

    $project->skills()->attach($skill->id, ['proficiency' => 'primary']);

    $attached = $project->skills()->first();

    expect($attached->pivot->proficiency)->toBe('primary');
});

it('attaches categories through the polymorphic categorizable relation', function () {
    $project = Project::factory()->create();
    $category = Category::factory()->create();

    $project->categories()->attach($category->id);

    expect($project->categories()->count())->toBe(1)
        ->and($category->projects()->first()->is($project))->toBeTrue();
});

it('soft deletes projects instead of removing them', function () {
    $project = Project::factory()->create();

    $project->delete();

    expect(Project::find($project->id))->toBeNull()
        ->and(Project::withTrashed()->find($project->id))->not->toBeNull();
});
