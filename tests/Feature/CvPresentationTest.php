<?php

use App\Enums\CvStatus;
use App\Enums\CvTemplate;
use App\Models\Cv;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the engineering CV layout with selected projects and grouped skills', function () {
    $cv = Cv::create([
        'title' => 'Engineering CV',
        'version_label' => 'Full-Stack Developer',
        'slug' => 'engineering-cv',
        'template' => CvTemplate::Engineering,
        'status' => CvStatus::Published,
        'headline' => 'Full-Stack Developer',
        'summary' => 'Builds reliable backend systems.',
        'skills' => [
            ['name' => 'NestJS', 'group' => 'Backend'],
        ],
        'projects' => [
            ['title' => 'Orientation-BJ API', 'description' => 'RIASEC platform'],
        ],
    ]);

    $this->get(localized_route('cv.show', $cv))
        ->assertOk()
        ->assertSee('Professional Summary')
        ->assertSee('Selected Projects')
        ->assertSee('Orientation-BJ API')
        ->assertSee('Backend');
});
