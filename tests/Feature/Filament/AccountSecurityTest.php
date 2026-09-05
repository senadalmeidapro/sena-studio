<?php

use App\Livewire\Filament\AccountSecurity;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('updates the password with the current password', function () {
    $user = User::factory()->create(['password' => bcrypt('old-password')]);

    Livewire::actingAs($user)
        ->test(AccountSecurity::class)
        ->fillForm([
            'current_password' => 'old-password',
            'password' => 'New-Passw0rd!',
            'password_confirmation' => 'New-Passw0rd!',
        ])
        ->call('updatePassword');

    expect(Hash::check('New-Passw0rd!', $user->fresh()->password))->toBeTrue();
});

it('rejects an incorrect current password', function () {
    $user = User::factory()->create(['password' => bcrypt('old-password')]);

    Livewire::actingAs($user)
        ->test(AccountSecurity::class)
        ->fillForm([
            'current_password' => 'wrong-password',
            'password' => 'New-Passw0rd!',
            'password_confirmation' => 'New-Passw0rd!',
        ])
        ->call('updatePassword')
        ->assertNotified(Notification::make()
            ->title('Le mot de passe actuel est incorrect.')
            ->danger());

    expect(Hash::check('old-password', $user->fresh()->password))->toBeTrue();
});

it('validates the new password and its confirmation', function () {
    $user = User::factory()->create(['password' => bcrypt('old-password')]);

    Livewire::actingAs($user)
        ->test(AccountSecurity::class)
        ->fillForm([
            'current_password' => 'old-password',
            'password' => 'mooc',
            'password_confirmation' => 'different',
        ])
        ->call('updatePassword')
        ->assertHasFormErrors(['password', 'password_confirmation']);

    expect(Hash::check('old-password', $user->fresh()->password))->toBeTrue();
});
it('enables two-factor and confirms with a recovery code', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)->test(AccountSecurity::class)->call('enableTwoFactor');

    $user->refresh();
    expect($user->two_factor_secret)->not->toBeNull();
    expect($user->hasEnabledTwoFactorAuthentication())->toBeFalse();

    $codes = json_decode(Fortify::currentEncrypter()->decrypt($user->two_factor_recovery_codes), true);
    expect($codes)->toHaveCount(8);

    $component = new AccountSecurity;
    $component->user = $user;
    (new ReflectionMethod(AccountSecurity::class, 'confirmTwoFactor'))->invoke($component, $codes[0], true);

    $user->refresh();
    expect($user->hasEnabledTwoFactorAuthentication())->toBeTrue();

    $remaining = json_decode(Fortify::currentEncrypter()->decrypt($user->two_factor_recovery_codes), true);
    expect($remaining)->not->toContain($codes[0]);
});

it('disables two-factor authentication', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)->test(AccountSecurity::class)->call('enableTwoFactor');

    $user->refresh();
    app(DisableTwoFactorAuthentication::class)($user);

    $user->refresh();
    expect($user->two_factor_secret)->toBeNull();
    expect($user->hasEnabledTwoFactorAuthentication())->toBeFalse();
});

it('renders the QR code SVG after enabling two-factor', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(AccountSecurity::class)
        ->call('enableTwoFactor')
        ->assertSee('<svg', escape: false);
});
