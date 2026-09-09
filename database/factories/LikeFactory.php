<?php

namespace Database\Factories;

use App\Models\ImagePost;
use App\Models\Like;
use App\Models\TextPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([TextPost::class, ImagePost::class]);

        return [
            'user_id' => User::factory(),
            'likeable_type' => $type,
            'likeable_id' => $type::factory(),
        ];
    }
}
