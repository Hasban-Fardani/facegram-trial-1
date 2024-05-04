<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'following_id' => fake()->numberBetween(1, 12),
            'follower_id' => fake()->numberBetween(1, 12),
            'is_accepted' => fake()->numberBetween(0, 1),
        ];
    }
}
