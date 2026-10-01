<?php

use App\Enums\ProjectStatus;
use App\Enums\ProjectVisibility;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Skill;
use App\Services\CloudinaryService;

it('casts project enum columns to their backed enum classes', function () {
    $project = Project::factory()->create([
        'status' => ProjectStatus::Production->value,
        'visibility' => ProjectVisibility::Public->value,
    ]);

    expect($project->status)->toBeInstanceOf(ProjectStatus::class)
        ->and($project->status)->toBe(ProjectStatus::Production)
        ->and($project->visibility)->toBe(ProjectVisibility::Public);
});

it('attaches skills without a proficiency pivot', function () {
    $project = Project::factory()->create();
    $skill = Skill::factory()->create();

    $project->skills()->attach($skill->id);

    $attached = $project->skills()->first();

    expect($attached->pivot->getAttributes())->not->toHaveKey('proficiency');
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

it('deletes a gallery asset using its cloudinary url when no public id is stored', function () {
    $project = Project::factory()->create();
    $image = ProjectImage::create([
        'project_id' => $project->id,
        'path' => 'https://res.cloudinary.com/demo/image/upload/v123/sena-studio/gallery/preview.png',
    ]);
    $cloudinary = Mockery::mock(CloudinaryService::class);
    $cloudinary->shouldReceive('publicIdFromUrl')
        ->once()
        ->with($image->path)
        ->andReturn('sena-studio/gallery/preview');
    $cloudinary->shouldReceive('delete')
        ->once()
        ->with('sena-studio/gallery/preview')
        ->andReturn([]);
    $this->app->instance(CloudinaryService::class, $cloudinary);

    $image->delete();

    expect(ProjectImage::find($image->id))->toBeNull();
});

it('deletes gallery records and their assets before force deleting a project', function () {
    $project = Project::factory()->create();
    $image = ProjectImage::create([
        'project_id' => $project->id,
        'path' => 'images/screenshots/project-1.svg',
    ]);

    $project->forceDelete();

    expect(Project::withTrashed()->find($project->id))->toBeNull()
        ->and(ProjectImage::find($image->id))->toBeNull();
});
