<?php

use App\Enums\CvStatus;
use App\Filament\Resources\Cvs\Pages\CreateCv;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders the engineering CV layout with selected projects and grouped skills', function () {
    $cv = Cv::create([
        'title' => 'Engineering CV',
        'version_label' => 'Full-Stack Developer',
        'slug' => 'engineering-cv',
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

it('renders language CEFR levels without rendering skill ratings or duration claims', function () {
    $cv = Cv::create([
        'title' => 'Engineering CV',
        'version_label' => 'Backend Developer',
        'slug' => 'backend-cv-levels',
        'status' => CvStatus::Published,
        'headline' => 'Backend Developer',
        'skills' => [
            ['name' => 'Laravel', 'group' => 'Backend', 'level' => 'expert', 'experience' => '8 ans'],
        ],
        'languages' => [
            ['name' => 'French', 'level' => 'C1'],
            ['name' => 'Fon'],
        ],
    ]);

    $this->get(localized_route('cv.show', $cv))
        ->assertOk()
        ->assertSee('Laravel')
        ->assertSee('French')
        ->assertSee('C1')
        ->assertSee('Fon')
        ->assertDontSee('expert')
        ->assertDontSee('8 ans');
});

it('does not offer unused skill level or duration fields in the CV editor', function () {
    Livewire::actingAs(User::factory()->admin()->create())
        ->test(CreateCv::class)
        ->assertFormFieldDoesNotExist('skills.0.level')
        ->assertFormFieldDoesNotExist('skills.0.experience');
});
