<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),

            // 'user_id' => User::factory()->create()->id,

            // 'user_id' => function () {
            //     return User::factory()->create()->id;
            // },

            'status' => Post::OPEN,
            'title' => $this->faker->realText(20),
            'body' => $this->faker->realText(200),
        ];
    }

    public function random()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => $this->faker->randomElement([1, 1, 1, 1, 0]),
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Post::CLOSED,
            ];
        });
    }
}
