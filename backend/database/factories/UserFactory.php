<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public const NUMBER = 10;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->text(16),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('11111111'),
            'isEmailPublic' => $this->faker->boolean(30),
            'picture' => $this->faker->imageUrl(),
            'bio' => $this->faker->text(200),
            'color' => $this->faker->hexColor(),
        ];
    }
}
