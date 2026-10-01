<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()),
            'description' => $this->faker->optional()->sentence(),
            'category' => $this->faker->randomElement(['backend', 'frontend', 'database', 'devops', 'tools']),
            'is_active' => true,
            'icon' => $this->faker->randomElement(['🐘', '⚡', '🎨', '🗄️', '☁️', '🧪', '🛠️', '🌿', '🔷', '🚀']),
        ];
    }
}
