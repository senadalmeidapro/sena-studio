<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected static int $sequence = 0;

    public function definition(): array
    {
        static::$sequence++;

        $titles = [
            'Concevoir un back-office Laravel à la main',
            'Laravel + Filament : retour d’expérience',
            'Choisir sa stack pour un SaaS en 2026',
            'L’art de l’API REST avec PostgreSQL',
            'Dockeriser une application Laravel pas à pas',
            'Performance : les 10 réflexes à adopter',
        ];

        $title = $titles[static::$sequence % count($titles)];

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.static::$sequence,
            'excerpt' => 'Extrait de l’article gratuit : points clés, erreurs à éviter et bonnes pratiques à retenir.',
            'content' => '<h2>Introduction</h2><p>Le contenu de cet article aborde des sujets concrets, illustrés par des exemples réels.',
            'cover_image' => null,
            'status' => Post::STATUS_PUBLISHED,
            'published_at' => now()->subDays(static::$sequence),
            'seo_title' => $title,
            'seo_description' => 'Extrait de l’article gratuit : points clés, erreurs à éviter et bonnes pratiques à retenir.',
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Post::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }
}
