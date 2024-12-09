<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GooAuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página Principal
Route::get('/', [MainController::class, 'index'])->name('inicio');

// Búsqueda de Juegos
Route::get('/games/search', [GameController::class, 'search'])->name('games.search');

// Detalles del Juego
Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');
// Juegos - Productos
Route::get('/games', [GameController::class, 'index'])->name('games');

// Carrito de Compras
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');

//registrar pedidos

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
});

// Contacto
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// Terminos y condiones
Route::view('/terminos-y-condiciones', '/recursos/terminos')->name('terminos');
Route::view('/politicas-de-privacidad', '/recursos/politicas')->name('politicas');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// registro con google
Route::get('/google-auth/redirect', [GooAuthController::class, 'redirect'])->name('goo_auth.redirect'); 
Route::get('/google-auth/callback', [GooAuthController::class, 'callback'])->name('goo_auth.callback');


//Verificar si el usuario está logueado (antes de proceder con el pago)
Route::get('/check-login', function () {
    return response()->json([
        'loggedIn' => auth()->check()
    ]);
});