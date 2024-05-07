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
        do {
            $following_id = $this->faker->numberBetween(1, 12);
            $follower_id = $this->faker->numberBetween(1, 12);
        } while ($following_id === $follower_id);

        return [
            'following_id' => $following_id,
            'follower_id' => $follower_id,
            'is_accepted' => fake()->numberBetween(0, 1),
        ];
    }
}
