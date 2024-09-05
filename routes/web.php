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

$router->get('/', function () {
    return response()->json(['message' => 'Application health check passed.'], 200);
});
$router->group(['prefix' => 'tasks'], function () use ($router) {
    $router->get('/search', 'TaskController@search');
    $router->post('/', 'TaskController@create');
    $router->put('/{id}', 'TaskController@update');
    $router->get('/', 'TaskController@index');
    $router->get('/{id}', 'TaskController@show');
    $router->delete('/{id}', 'TaskController@delete');
});
