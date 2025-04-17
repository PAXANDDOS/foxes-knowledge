<?php

namespace Database\Factories;

use App\Enums\ReactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    public const NUMBER = 90;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, UserFactory::NUMBER),
            'post_id' => $this->faker->numberBetween(1, PostFactory::NUMBER),
            'comment_id' => $this->faker->numberBetween(1, CommentFactory::NUMBER),
            'type' => $this->faker->randomElement(ReactionType::values()),
        ];
    }
}
