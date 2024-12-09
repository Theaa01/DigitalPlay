<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'discounted_price',
        'stock',
        'active',
        'image',
        'description',
        'release_date',
        'is_popular',
    ];

    // Relaciones
    public function consoles()
    {
        return $this->belongsToMany(Console::class, 'game_console', 'game_id', 'console_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
