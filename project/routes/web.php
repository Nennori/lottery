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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('', 'UserController@index');
        $router->post('/register', 'UserController@store');
        $router->put('/{id}', 'UserController@update');
        $router->delete('/{id}', 'UserController@delete');
        $router->post('/login', 'AuthController@login');
    });

    $router->get('/lottery_games', 'LotteryGameController@index');
    $router->post('/lottery_game_matches', 'LotteryGameMatchController@store');
    $router->put('/lottery_game_matches', 'LotteryGameMatchController@finishMatch');
    $router->post('/lottery_game_match_users', 'LotteryGameMatchController@addUser');
    $router->get('/lottery_game_matches', 'LotteryGameMatchController@index');
});
