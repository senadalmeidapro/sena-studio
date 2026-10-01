<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\InvoiceStatus;
use App\Models\Engagement;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return ['engagement_id' => Engagement::factory(), 'number' => fake()->unique()->bothify('INV-####'), 'amount' => fake()->numberBetween(10000, 500000), 'currency' => Currency::EUR, 'issued_at' => now()->toDateString(), 'due_at' => now()->addDays(14)->toDateString(), 'paid_at' => null, 'status' => InvoiceStatus::Sent];
    }
}
