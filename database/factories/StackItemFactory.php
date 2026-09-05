<?php

namespace Database\Factories;

use App\Models\Stack;
use App\Models\StackItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StackItemFactory extends Factory
{
    protected $model = StackItem::class;

    public function definition(): array
    {
        return [
            'stack_id' => Stack::factory(),
            'category' => $this->faker->randomElement([
                'frontend', 'backend', 'database', 'cache', 'queue', 'orm', 'devops',
                'testing', 'design', 'cloud', 'monitoring',
            ]),
            'value' => ucfirst($this->faker->unique()->word()),
            'version' => $this->faker->optional()->semver(),
            'icon' => $this->faker->randomElement(['🐘', '⚡', '🌿', '🔷', '🧩', '🚀', '🗄️', '☁️', '🐬', '📡', '🧪', '🛠️']),
        ];
    }
}
