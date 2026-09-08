<?php

use App\Livewire\Filament\AccountSecurity;
use App\Models\User;
use Livewire\Livewire;

it('mounts the confirmTwoFactor action modal', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(AccountSecurity::class)
        ->call('mountAction', 'confirmTwoFactor')
        ->assertOk()
        ->assertSee('wire:partial="action-modals', false);
});
