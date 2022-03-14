<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\VendasController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(["prefix" => "api"], function() use ($router) {
    $router->get("/vendas", ['uses' => 'VendasController@Vendas']);
    $router->get("/cliente/{documento}", ['uses' => 'VendasController@Cliente']);
    $router->get("/parcelas/{code}/{key}", ['uses' => 'VendasController@Parcelas']);
});
