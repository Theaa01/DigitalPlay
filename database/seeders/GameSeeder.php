<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Category;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->count() == 0) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        Game::factory()->count(30)->create();
    }
}
