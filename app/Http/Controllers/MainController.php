<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Comment;

class MainController extends Controller
{
    /**
     * Mostrar la página principal.
     */
    public function index()
    {
        // Obtener juegos populares con sus detalles
        $popularGames = Game::with('comments')
            ->where('is_popular', true) // Filtrar solo los juegos populares
            ->get();


        // Obtener todos los juegos paginados
        $allGames = Game::paginate(6); // Ajusta el número por página según tus necesidades

        // Obtener los 6 comentarios más recientes de cualquier juego
        $comments = Comment::with('game')
            ->latest()
            ->get()
            ->unique('game_id')
            ->take(3);

        return view('index', compact('popularGames', 'allGames', 'comments'));
    }


    /**
     * Manejar la búsqueda de juegos.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->input('query');
        $games = Game::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($games);
    }
}
