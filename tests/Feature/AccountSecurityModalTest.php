<?php

use App\Livewire\Filament\AccountSecurity;
use App\Models\User;
use Livewire\Livewire;

it('renders the mobile action modal', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(AccountSecurity::class);

    $component->call('mountAction', 'confirmTwoFactor');

    $component->assertOk();
});