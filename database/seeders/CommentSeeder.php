<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Game;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::all()->each(function ($game) {
            Comment::factory()->count(5)->create(['game_id' => $game->id]);
        });
    }
}
