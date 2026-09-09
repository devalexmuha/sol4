<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\ImagePost;
use App\Models\TextPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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
            'user_id'          => User::factory(),
            'body'             => fake()->realText(rand(40, 200)),
            'commentable_type' => $type,
            'commentable_id'   => $type::factory(),
        ];
    }
}
