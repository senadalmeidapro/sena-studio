<?php

namespace Database\Factories;

use App\Enums\SkillLevel;
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
            'level' => $this->faker->randomElement(SkillLevel::cases())->value,
            'is_active' => true,
            'icon' => null,
        ];
    }
}
