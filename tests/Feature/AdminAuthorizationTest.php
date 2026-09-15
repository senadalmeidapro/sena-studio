<?php

use App\Models\Cv;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function userWithoutAdminRole(): User
{
    $user = User::factory()->create();

    ModelHasRole::query()
        ->where('model_type', User::class)
        ->where('model_id', $user->getKey())
        ->delete();

    return $user;
}

it('blocks users without the admin role from the Filament panel', function () {
    $user = userWithoutAdminRole();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

it('blocks users without the admin role from downloading CV files', function () {
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
