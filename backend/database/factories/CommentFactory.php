<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public const NUMBER = 40;

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
            'content' => $this->faker->realText(),
        ];
    }
}
