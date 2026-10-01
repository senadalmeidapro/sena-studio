<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('fails clearly when production seeding lacks admin credentials', function () {
    $previousEnvironment = config('app.env');
    $previousAdminEmail = config('admin.email');
    $previousAdminPassword = config('admin.password');
    config(['app.env' => 'production']);
    config(['admin.email' => null, 'admin.password' => null]);

    try {
        expect(fn () => (new DatabaseSeeder)->run())
            ->toThrow(RuntimeException::class, 'ADMIN_EMAIL and ADMIN_PASSWORD must be set');
    } finally {
        config(['app.env' => $previousEnvironment]);
        config(['admin.email' => $previousAdminEmail, 'admin.password' => $previousAdminPassword]);
    }
});

it('explicitly grants admin status to the configured seeder account', function () {
    config([
        'admin.email' => 'admin@example.test',
        'admin.password' => 'secure-password',
        'admin.name' => 'Site Admin',
    ]);

    (new DatabaseSeeder)->run();

    expect(User::where('email', 'admin@example.test')->first()->isAdmin())->toBeTrue();
});
