<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\Category;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        $categories = Category::all()->pluck('id')->toArray();
        return [
            'category_id' => $this->faker->randomElement($categories),
            'name' => ucfirst($this->faker->unique()->words(3, true)),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discounted_price' => $this->faker->optional()->randomFloat(2, 5, 90),
            'image' => 'images/games/' . $this->faker->image('public/images/games', 640, 480, null, false),
            'description' => $this->faker->paragraph,
            'is_popular' => $this->faker->boolean(30), // 30% de probabilidad de ser popular
        ];
    }
}
