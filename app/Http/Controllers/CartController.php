<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Mostrar el carrito de compras.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // Calcular el total de artículos
        $cartCount = collect($cart)->sum('quantity');

        // Calcular Precio Oficial
        $officialPrice = collect($cart)->reduce(function ($carry, $item) {
            return $carry + (($item['discounted_price'] ?? $item['price']) * $item['quantity']);
        }, 0);

        // Calcular Descuento
        $discount = collect($cart)->reduce(function ($carry, $item) {
            if (isset($item['discounted_price']) && $item['discounted_price'] > $item['price']) {
                return $carry + (($item['discounted_price'] - $item['price']) * $item['quantity']);
            }
            return $carry;
        }, 0);

        // Calcular Subtotal
        $subtotal = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Obtener juegos recomendados (puedes personalizar esta lógica)
        $recommendedGames = Game::inRandomOrder()->take(4)->get();

        return view('cart', compact('cart', 'cartCount', 'officialPrice', 'discount', 'subtotal', 'recommendedGames'));
    }

    /**
     * Agregar un juego al carrito.
     */
    public function add(Request $request, $id)
    {
        try {
            $game = Game::findOrFail($id);
            $cart = session()->get('cart', []);

            // Determinar si el juego tiene un precio descontado válido
            $hasDiscount = isset($game->discounted_price) && $game->discounted_price > $game->price;

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
            } else {
                $cart[$id] = [
                    "name" => $game->name,
                    "price" => $game->price, // Precio descontado
                    "quantity" => 1,
                    "image" => $game->image,
                    "discounted_price" => $hasDiscount ? $game->discounted_price : null
                ];
            }

            session()->put('cart', $cart);

            // Calcular los nuevos valores
            $cartCount = collect($cart)->sum('quantity');
            $officialPrice = collect($cart)->reduce(function ($carry, $item) {
                return $carry + (($item['discounted_price'] ?? $item['price']) * $item['quantity']);
            }, 0);

            $discount = collect($cart)->reduce(function ($carry, $item) {
                if (isset($item['discounted_price']) && $item['discounted_price'] > $item['price']) {
                    return $carry + (($item['discounted_price'] - $item['price']) * $item['quantity']);
                }
                return $carry;
            }, 0);

            $subtotal = collect($cart)->reduce(function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Renderizar los partials para la vista principal y el modal
            $mainCartItems = view('partials.cart-items', ['cart' => $cart])->render();
            $modalCartItems = view('partials.cart-items', ['cart' => $cart])->render();

            return response()->json([
                'success' => 'Juego añadido al carrito',
                'cartCount' => $cartCount,
                'mainCartItems' => $mainCartItems,
                'modalCartItems' => $modalCartItems,
                'officialPrice' => number_format($officialPrice, 2),
                'discount' => number_format($discount, 2),
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2) // Para el modal, el total es el subtotal
            ]);
        } catch (\Exception $e) {
            Log::error("Error al agregar al carrito: " . $e->getMessage());
            return response()->json([
                'error' => 'Hubo un error al agregar el juego al carrito.'
            ], 500);
        }
    }

    /**
     * Eliminar un juego del carrito.
     */
    public function remove(Request $request, $id)
    {
        try {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }

            // Calcular los nuevos valores
            $cartCount = collect($cart)->sum('quantity');
            $officialPrice = collect($cart)->reduce(function ($carry, $item) {
                return $carry + (($item['discounted_price'] ?? $item['price']) * $item['quantity']);
            }, 0);

            $discount = collect($cart)->reduce(function ($carry, $item) {
                if (isset($item['discounted_price']) && $item['discounted_price'] > $item['price']) {
                    return $carry + (($item['discounted_price'] - $item['price']) * $item['quantity']);
                }
                return $carry;
            }, 0);

            $subtotal = collect($cart)->reduce(function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Renderizar los partials para la vista principal y el modal
            $mainCartItems = view('partials.cart-items', ['cart' => $cart])->render();
            $modalCartItems = view('partials.cart-items', ['cart' => $cart])->render();

            return response()->json([
                'success' => 'Juego eliminado del carrito',
                'cartCount' => $cartCount,
                'mainCartItems' => $mainCartItems,
                'modalCartItems' => $modalCartItems,
                'officialPrice' => number_format($officialPrice, 2),
                'discount' => number_format($discount, 2),
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2), // Para el modal, el total es el subtotal
            ]);
        } catch (\Exception $e) {
            Log::error("Error al eliminar del carrito: " . $e->getMessage());
            return response()->json([
                'error' => 'Hubo un error al eliminar el juego del carrito.'
            ], 500);
        }
    }

    /**
     * Actualizar la cantidad de un juego en el carrito.
     */
    public function updateQuantity(Request $request, $id)
    {
        try {
            $quantity = intval($request->input('quantity')); // Obtener la cantidad seleccionada

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity; // Actualizar con la cantidad absoluta

                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }

                session()->put('cart', $cart);
            }

            // Calcular los nuevos valores
            $cartCount = collect($cart)->sum('quantity');
            $officialPrice = collect($cart)->reduce(function ($carry, $item) {
                return $carry + (($item['discounted_price'] ?? $item['price']) * $item['quantity']);
            }, 0);

            $discount = collect($cart)->reduce(function ($carry, $item) {
                if (isset($item['discounted_price']) && $item['discounted_price'] > $item['price']) {
                    return $carry + (($item['discounted_price'] - $item['price']) * $item['quantity']);
                }
                return $carry;
            }, 0);

            $subtotal = collect($cart)->reduce(function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Renderizar los partials para la vista principal y el modal
            $mainCartItems = view('partials.cart-items', ['cart' => $cart])->render();
            $modalCartItems = view('partials.cart-items', ['cart' => $cart])->render();

            return response()->json([
                'success' => 'Cantidad actualizada',
                'cartCount' => $cartCount,
                'mainCartItems' => $mainCartItems,
                'modalCartItems' => $modalCartItems,
                'officialPrice' => number_format($officialPrice, 2),
                'discount' => number_format($discount, 2),
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2)
            ]);
        } catch (\Exception $e) {
            Log::error("Error al actualizar la cantidad: " . $e->getMessage());
            return response()->json([
                'error' => 'Hubo un error al actualizar la cantidad.'
            ], 500);
        }
    }

    /**
     * Limpiar todo el carrito.
     */
    public function clear(Request $request)
    {
        try {
            session()->forget('cart');
            $cart = []; // Definir el carrito como vacío
            $cartCount = 0;
            $officialPrice = 0.00;
            $discount = 0.00;
            $subtotal = 0.00;

            // Renderizar los partials para la vista principal y el modal
            $mainCartItems = view('partials.cart-items', ['cart' => $cart])->render();
            $modalCartItems = view('partials.cart-items', ['cart' => $cart])->render();

            return response()->json([
                'success' => 'Carrito limpio exitosamente',
                'cartCount' => $cartCount,
                'mainCartItems' => $mainCartItems,
                'modalCartItems' => $modalCartItems,
                'officialPrice' => number_format($officialPrice, 2),
                'discount' => number_format($discount, 2),
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2)
            ]);
        } catch (\Exception $e) {
            Log::error("Error al limpiar el carrito: " . $e->getMessage());
            return response()->json([
                'error' => 'Hubo un error al limpiar el carrito.'
            ], 500);
        }
    }

    /**
     * Obtener los ítems del carrito (para el modal).
     */
    public function getCartItems()
    {
        $cart = session()->get('cart', []);

        // Renderizar solo los ítems del carrito sin totales ni recomendaciones
        return view('partials.cart-items', ['cart' => $cart])->render();
    }
}
