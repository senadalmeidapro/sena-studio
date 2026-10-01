<?php

use Database\Seeders\DatabaseSeeder;

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
