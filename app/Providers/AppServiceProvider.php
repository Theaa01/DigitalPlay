<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\CartComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.env') === 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir la variable 'cart' en todas las vistas
        View::composer('*', function ($view) {
            $cart = session()->get('cart', []);
            $view->with('cart', $cart);
        });
        View::composer('*', CartComposer::class);
    }
}
