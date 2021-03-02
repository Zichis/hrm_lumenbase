<?php

$router->get(
    '/', function () use ($router) {
        return $router->app->version();
    }
);

$router->get(
    'user/roles', [
    'middleware' => 'auth',
    'uses' => 'UserController@roles'
    ]
);
$router->get('users/count', 'UserController@count');
$router->group(
    ['middleware' => ['auth', 'admin']], function () use ($router) {
        $router->group(
            ['prefix' => 'users'], function () use ($router) {
                $router->get('/', 'UserController@index');
                $router->get('{id}', 'UserController@show');
                $router->put('{id}', 'UserController@update');
                $router->post('/', 'UserController@create');
                $router->delete('{id}', 'UserController@destroy');
            }
        );
    }
);

$router->get('attendance', 'Admin\AttendanceController@index');
$router->get('attendance/clock-in', 'AttendanceController@clockIn');
$router->get('attendance/clock-out', 'AttendanceController@clockOut');
$router->get('attendance/status', 'AttendanceController@status');

$router->get(
    'profile', [
    'middleware' => 'auth',
    'uses' => 'ProfileController@index'
    ]
);

$router->get(
    'current-user', [
    'middleware' => 'auth',
    'uses' => 'UserController@current'
    ]
);
$router->post(
    'onboard', [
    'uses' => 'UserController@onboard'
    ]
);
$router->post('login', 'LoginController@login');
$router->get('logout', 'UserController@logout');
