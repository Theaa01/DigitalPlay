<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Game;

class ProductCard extends Component
{
    public $game;

    /**
     * Create a new component instance.
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.product-card');
    }
}
