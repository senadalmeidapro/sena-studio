<?php

use App\Filament\Pages\SiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Livewire\Livewire;

it('lets the admin edit availability and an optional booking URL', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(SiteSettings::class)
        ->fillForm(['availability' => 'limited', 'booking_url' => 'https://cal.example.test/sena'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->availability)->toBe('limited')
        ->and(SiteSetting::current()->booking_url)->toBe('https://cal.example.test/sena');
});
