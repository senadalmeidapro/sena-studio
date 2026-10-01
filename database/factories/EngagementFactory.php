<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Enums\EngagementStatus;
use App\Models\Client;
use App\Models\Engagement;
use Illuminate\Database\Eloquent\Factories\Factory;

class EngagementFactory extends Factory
{
    protected $model = Engagement::class;

    public function definition(): array
    {
        return ['client_id' => Client::factory(), 'title' => fake()->sentence(3), 'scope' => fake()->paragraph(), 'pricing_model' => EngagementPricingModel::Fixed, 'amount' => fake()->numberBetween(10000, 500000), 'currency' => Currency::EUR, 'status' => EngagementStatus::Proposal];
    }
}
