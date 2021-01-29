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

$router->get('users', [
    'middleware' => 'auth',
    'uses' => 'UserController@index'
]);
$router->get('users/count', [
    'uses' => 'UserController@count'
]);
$router->get('users/{id}', [
    'middleware' => 'auth',
    'uses' => 'UserController@show'
]);
$router->put('users/{id}', [
    'middleware' => 'auth',
    'uses' => 'UserController@update'
]);
$router->post('users', [
    'middleware' => 'auth',
    'uses' => 'UserController@create'
]);
$router->delete('users/{id}', [
    'middleware' => 'auth',
    'uses' => 'UserController@destroy'
]);
$router->get('profile', [
    'middleware' => 'auth',
    'uses' => 'ProfileController@index'
]);
$router->get('current-user', [
    'middleware' => 'auth',
    'uses' => 'UserController@current'
]);
$router->post('onboard', [
    'uses' => 'UserController@onboard'
]);
$router->post('login', 'LoginController@login');
$router->get('logout', 'UserController@logout');
