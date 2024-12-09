<?php

use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\CommentController;
use App\Admin\Controllers\GameController;
use App\Admin\Controllers\ConsoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use OpenAdmin\Admin\Facades\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    //Category, Game y Comment
    $router->resource('categories', CategoryController::class);
    $router->resource('games', GameController::class);
    $router->resource('consoles', ConsoleController::class);
    $router->resource('comments', CommentController::class);
});
