<?php

namespace Database\Factories;

use App\Models\Stack;
use Illuminate\Database\Eloquent\Factories\Factory;

class StackFactory extends Factory
{
    protected $model = Stack::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()).' Stack',
            'description' => $this->faker->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
