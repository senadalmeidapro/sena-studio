<?php

use App\Models\Cv;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function userWithoutAdminRole(): User
{
    return User::factory()->nonAdmin()->create();
}

it('uses the admin flag for panel access', function () {
    $admin = User::factory()->create();
    $nonAdmin = User::factory()->nonAdmin()->create();

    expect($admin->isAdmin())->toBeTrue()
        ->and($nonAdmin->isAdmin())->toBeFalse();

    $this->actingAs($admin)->get('/admin')->assertSuccessful();
});

it('blocks users without the admin flag from the Filament panel', function () {
    $user = userWithoutAdminRole();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

it('blocks users without the admin flag from downloading CV files', function () {
    $user = userWithoutAdminRole();

    $cv = Cv::create([
        'title' => 'Curriculum vitae',
        'version_label' => 'V1',
        'slug' => 'protected-cv',
        'template' => 'moderne',
        'status' => 'published',
        'headline' => 'Software Engineer',
    ]);

    $this->actingAs($user)
        ->get(route('admin.cvs.pdf', $cv))
        ->assertForbidden();
});
