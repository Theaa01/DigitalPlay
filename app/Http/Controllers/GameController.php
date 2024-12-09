<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Console;  // Importar el modelo Console
use App\Models\Category;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::with('category', 'comments')
            ->where('active', true)
            // ->where('stock', '>', 0)
            ->findOrFail($id);

        return view('games.show', compact('game'));
    }

    public function index(Request $request)
    {
        // Consulta base para los juegos
        // $query = Game::query();
        $query = Game::where('active', true); // Filtrar solo juegos activos

        // Filtro por stock (solo juegos disponibles)
        if ($request->has('in_stock')) {
            $query->where('stock', '>', 0);  // Asumiendo que 'stock' es el campo que representa la cantidad
        }

        // Filtro por consola
        if ($request->has('console') && $request->console !== 'all') {
            $query->whereHas('consoles', function ($query) use ($request) {
                $query->where('console_id', $request->console);
            });
        }

        // Filtro por categoría (género)
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Filtro para ordenar
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderByRaw('IFNULL(price, discounted_price) ASC');
                    break;
                case 'price_desc':
                    $query->orderByRaw('IFNULL(price, discounted_price) DESC');
                    break;
                case 'discount_desc':
                    $query->selectRaw('*, IFNULL(100 - (price / discounted_price) * 100, 0) AS discount_percentage')
                        ->orderBy('discount_percentage', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'DESC');
                    break;
            }
        }

        // Filtro por rango de precios
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $priceMin = $request->input('price_min');
            $priceMax = $request->input('price_max');

            $query->whereBetween('price', [$priceMin, $priceMax]);
        }

        // Obtener los juegos paginados
        $games = $query->paginate(24);

        // Obtener las categorías para los filtros
        $categories = Category::all();
        $consoles = Console::all();  // Obtener todas las consolas disponibles

        return view('games', compact('games', 'categories', 'consoles'));
    }


    public function search(Request $request)
    {
        $query = Game::where('active', true); // Filtrar solo juegos activos

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $games = $query->get();
        $total = $games->count();  // Obtener el total de resultados

        // Devuelve solo los juegos y el total en formato JSON
        return response()->json([
            'html' => view('partials.games-list', compact('games'))->render(),
            'total' => $total,  // Incluye el total de resultados
        ]);
    }
}
