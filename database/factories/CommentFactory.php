<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Game;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'game_id' => Game::factory(),
            'user_name' => $this->faker->name,
            'user_image' => 'images/users/' . $this->faker->numberBetween(1, 10) . '.jpg',
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->sentence(12),
        ];
    }
}
