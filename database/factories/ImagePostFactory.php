<?php

namespace Database\Factories;

use App\Models\ImagePost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImagePost>
 */
class ImagePostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image_title' => fake()->realText(rand(40, 200)),
        ];
    }
}
