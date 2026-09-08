<?php

use App\Livewire\Filament\AccountSecurity;
use App\Models\User;
use Livewire\Livewire;

it('traces the modal mount failure', function (): void {
    $user = User::factory()->create();

    try {
        $c = Livewire::actingAs($user)->test(AccountSecurity::class);
        $c->call('mountAction', 'confirmTwoFactor');
        $c->assertOk();
    } catch (\Throwable $e) {
        fwrite(STDERR, "\n\n=== ".get_class($e)." ===\n".$e->getMessage()."\n--- TRACE ---\n".$e->getTraceAsString()."\n");
        throw $e;
    }
});