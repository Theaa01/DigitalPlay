<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    // app/Http/Controllers/OrderController.php
    public function index()
    {
        // Obtenemos las órdenes del usuario logueado
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // Valida los datos recibidos
        $validatedData = $request->validate([
            'transaction_id' => 'required|string',
            'payer_email' => 'required|email',
            'total' => 'required|numeric',
            'cart' => 'required|array',
        ]);

        // Crea la orden en la base de datos
        $order = Order::create([
            'user_id' => Auth::id(), // ID del usuario logeado
            'transaction_id' => $validatedData['transaction_id'],
            'payer_email' => $validatedData['payer_email'],
            'total_price' => $validatedData['total'],
            'items' => json_encode($validatedData['cart']), // Almacena los ítems como JSON
        ]);

        // Verifica si la orden fue creada correctamente
        if ($order) {
            // Limpia el carrito de la sesión
            session()->forget('cart');

            // Redirige a la vista de la orden, pasando el ID de la orden
            return response()->json([
                'success' => true,
                'order_id' => $order->id, // Retorna el ID de la orden
            ]);
        }

        // Si algo sale mal, devuelve un error
        return response()->json(['success' => false], 500);
    }


    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
