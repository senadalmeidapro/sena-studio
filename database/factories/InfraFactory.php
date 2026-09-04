<?php

namespace Database\Factories;

use App\Enums\InfraEnvironment;
use App\Models\Infra;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfraFactory extends Factory
{
    protected $model = Infra::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()).' Infra',
            'description' => $this->faker->optional()->sentence(),
            'docker_image' => null,
            'kubernetes_config' => null,
            'helm_chart' => null,
            'cpu_cores' => $this->faker->numberBetween(1, 8),
            'memory_mb' => $this->faker->randomElement([512, 1024, 2048, 4096]),
            'storage_gb' => $this->faker->numberBetween(10, 100),
            'environment' => $this->faker->randomElement(InfraEnvironment::cases())->value,
            'is_active' => true,
        ];
    }
}
