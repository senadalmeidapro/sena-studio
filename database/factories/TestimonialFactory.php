<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected static int $sequence = 0;

    public function definition(): array
    {
        static::$sequence++;

        $people = [
            ['Inès Traoré', 'Directrice produit', 'Atelier Nova'],
            ['Paul Renard', 'Fondateur', 'Kero'],
            ['Camille Bernard', 'CMO', 'Ledger & Co'],
            ['Awa Diallo', 'Lead dev', 'Studio Solaris'],
            ['Julien Petit', 'CEO', 'Oxo Labs'],
        ];

        $person = $people[static::$sequence % count($people)];

        return [
            'name' => $person[0],
            'role' => $person[1],
            'company' => $person[2],
            'avatar' => null,
            'content' => 'Un interlocuteur rigoureux et réactif. Livraison dans les temps, communication claire et un résultat qui dépasse nos attentes.',
            'sort_order' => static::$sequence,
            'is_visible' => true,
        ];
    }

    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_visible' => false,
        ]);
    }
}
