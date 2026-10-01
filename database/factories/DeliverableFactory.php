<?php

namespace Database\Factories;

use App\Models\Deliverable;
use App\Models\Engagement;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliverableFactory extends Factory
{
    protected $model = Deliverable::class;

    public function definition(): array
    {
        return ['engagement_id' => Engagement::factory(), 'title' => fake()->sentence(4), 'due_at' => fake()->dateTimeBetween('+1 day', '+2 months'), 'done_at' => null];
    }
}
