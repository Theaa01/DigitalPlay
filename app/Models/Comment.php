<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_name',
        'user_image',
        'rating',
        'review'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
