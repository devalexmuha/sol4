<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   => User::factory(),
            'user_name' => fake()->unique()->userName(),
            'user_bio'  => fake()->optional(0.7)->realText(rand(80, 200)),
        ];
    }

    public function withoutBio(): static
    {
        return $this->state(fn () => ['user_bio' => null]);
    }
}
