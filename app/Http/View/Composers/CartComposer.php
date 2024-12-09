<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $cart = session()->get('cart', []);
        // Calcular la suma total de las cantidades en el carrito
        $cartCount = collect($cart)->sum('quantity');
        $total = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $view->with([
            'cart' => $cart,
            'total' => $total,
            'cartCount' => $cartCount
        ]);
    }
}
