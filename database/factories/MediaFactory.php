<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUri = fake()->randomElement([
            'https://picsum.photos/seed/forest/900/1200',
            'https://picsum.photos/seed/mountain/900/1200',
            'https://picsum.photos/seed/ocean/900/1200',
            'https://picsum.photos/seed/desert/900/1200',
            'https://picsum.photos/seed/waterfall/900/1200',
            'https://picsum.photos/seed/lake/900/1200',
            'https://picsum.photos/seed/canyon/900/1200',
            'https://picsum.photos/seed/meadow/900/1200',
            'https://picsum.photos/seed/glacier/900/1200',
            'https://picsum.photos/seed/sunset/900/1200',
        ]);

        return [
            'media_uri' => $imageUri,
            'media_alt' => fake()->unique()->sentence(),
        ];
    }
}
