<?php

use App\Filament\Resources\AuditLogs\AuditLogResource;
use App\Filament\Resources\Permissions\PermissionResource;
use App\Filament\Resources\Roles\RoleResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps sensitive resources restricted to super admins', function () {
    $user = User::factory()->create();

    ModelHasRole::query()
        ->where('model_type', User::class)
        ->where('model_id', $user->getKey())
        ->delete();

    $this->actingAs($user);

    expect(UserResource::canViewAny())->toBeFalse()
        ->and(RoleResource::canViewAny())->toBeFalse()
        ->and(PermissionResource::canViewAny())->toBeFalse()
        ->and(AuditLogResource::canViewAny())->toBeFalse();
});
