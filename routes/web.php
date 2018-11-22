<?php

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

$router->get('/key', function () {
    return str_random(32);
});


// We are using a Middleware that doesn't require configuration
// https://github.com/vluzrmos/lumen-cors
$router->group(['middleware' => []], function () use ($router) {
    $router->post('/users/login', ['uses' => 'UsersController@getToken']);
    $router->post('/users', ['uses' => 'UsersController@createUser']);
});

$router->group(['middleware' => ['auth_buyer']], function () use ($router) {
    // Users
    $router->get('/users', ['uses' => 'UsersController@getAll']);
    $router->get('/users_seller', ['uses' => 'UsersController@getSellers']);
    $router->get('/users_buyer', ['uses' => 'UsersController@getBuyers']);
    $router->get('/users/{id}', ['uses' => 'UsersController@getUser']);
    $router->put('/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/users/{id}', ['uses' => 'UsersController@deleteUser']);
    $router->post('/users/logout', ['uses' => 'UsersController@logout']);

    // Category
    $router->post('/category', ['uses' => 'CategoryController@createCategory']);
    $router->get('/category', ['uses' => 'CategoryController@getAll']);
    $router->get('/category/{id}', ['uses' => 'CategoryController@getCategory']);
    $router->put('/category/{id}', ['uses' => 'CategoryController@updateCategory']);
    $router->delete('/category/{id}', ['uses' => 'CategoryController@deleteCategory']);

    // Stripe Subcriptions
    $router->post('/payment', ['uses' => 'PaymentsController@createSubscription']);

});