<?php

use App\Models\Cv;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('downloads the CV as a PDF for an authenticated user', function () {
    $user = User::factory()->create();
    $cv = Cv::create([
        'title' => 'Curriculum vitae',
        'version_label' => 'V1 - Fullstack',
        'slug' => 'test-cv',
        'template' => 'moderne',
        'status' => 'published',
        'headline' => 'Développeur',
    ]);

    $response = $this->actingAs($user)->get(route('admin.cvs.pdf', $cv));

    $response->assertSuccessful();
    $response->assertHeader('content-type', 'application/pdf');
    $response->assertHeader('content-disposition', 'attachment; filename=CV-V1---Fullstack.pdf');
    expect(substr($response->getContent(), 0, 5))->toBe('%PDF-');
});

it('redirects guests to the login page', function () {
    $cv = Cv::create([
        'title' => 'Curriculum vitae',
        'slug' => 'test-cv',
        'template' => 'moderne',
        'status' => 'draft',
        'headline' => 'Développeur',
    ]);

    $this->get(route('admin.cvs.pdf', $cv))->assertRedirect(route('login'));
});
