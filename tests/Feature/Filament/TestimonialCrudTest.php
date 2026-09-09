<?php

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('lists testimonials', function () {
    $user = User::factory()->create();
    $testimonial = Testimonial::factory()->create(['name' => 'Marie Dupont']);

    Livewire::actingAs($user)
        ->test(ListTestimonials::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$testimonial]);
});

it('creates a testimonial visible by default', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateTestimonial::class)
        ->fillForm([
            'name' => 'Marie Dupont',
            'role' => 'Directrice produit',
            'company' => 'Atelier Nova',
            'content' => 'Excellent accompagnement, livraison dans les temps.',
            'sort_order' => 4,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $testimonial = Testimonial::where('name', 'Marie Dupont')->first();

    expect($testimonial)->not->toBeNull()
        ->and($testimonial->role)->toBe('Directrice produit')
        ->and($testimonial->company)->toBe('Atelier Nova')
        ->and($testimonial->sort_order)->toBe(4)
        ->and($testimonial->is_visible)->toBeTrue();
});

it('validates required fields', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateTestimonial::class)
        ->fillForm([])
        ->call('create')
        ->assertHasFormErrors(['name', 'content']);
});

it('updates a testimonial and can hide it', function () {
    $user = User::factory()->create();
    $testimonial = Testimonial::factory()->create(['name' => 'Paul Renard']);

    Livewire::actingAs($user)
        ->test(EditTestimonial::class, ['record' => $testimonial->getRouteKey()])
        ->fillForm([
            'name' => 'Paul R.',
            'role' => 'Fondateur',
            'company' => 'Kero',
            'content' => 'Témoignage mis à jour.',
            'sort_order' => 2,
            'is_visible' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $testimonial->refresh();

    expect($testimonial->name)->toBe('Paul R.')
        ->and($testimonial->sort_order)->toBe(2)
        ->and($testimonial->is_visible)->toBeFalse();
});

it('deletes a testimonial', function () {
    $user = User::factory()->create();
    $testimonial = Testimonial::factory()->create();

    Livewire::actingAs($user)
        ->test(EditTestimonial::class, ['record' => $testimonial->getRouteKey()])
        ->callAction('delete');

    expect(Testimonial::find($testimonial->id))->toBeNull();
});
