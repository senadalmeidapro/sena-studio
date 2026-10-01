<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => str($name)->slug(),
            'description' => $this->faker->optional()->paragraph(),
            'deployment' => $this->faker->optional()->sentence(),
            'url' => $this->faker->optional()->url(),
            'repository_url' => $this->faker->optional()->url(),
            'image' => $this->faker->randomElement([
                'images/screenshots/project-1.svg',
                'images/screenshots/project-2.svg',
                'images/screenshots/project-3.svg',
                'images/screenshots/project-4.svg',
                'images/screenshots/project-5.svg',
            ]),
            'status' => $this->faker->randomElement(ProjectStatus::cases())->value,
            'type' => $this->faker->randomElement(ProjectType::cases())->value,
            'visibility' => ProjectVisibility::Public->value,
            'started_at' => $this->faker->optional()->date(),
            'ended_at' => null,
        ];
    }
}
