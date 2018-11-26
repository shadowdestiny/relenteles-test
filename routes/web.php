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

    $router->get('/category', ['uses' => 'CategoryController@getAll']);
    $router->get('/category/{id}', ['uses' => 'CategoryController@getCategory']);

    // Stripe Subcriptions
    $router->post('/payment', ['uses' => 'PaymentsController@createSubscription']);

    // Product
    $router->get('/products', ['uses' => 'ProductController@getAll']);
    $router->get('/products/{id}', ['uses' => 'ProductController@getProduct']);
    $router->get('/products_by_category/{category_id}', ['uses' => 'ProductController@getProductsByCategory']);
    $router->post('/products_find', ['uses' => 'ProductController@getProductsFind']);

});

$router->group(['middleware' => ['auth_seller']], function () use ($router) {
    // user
    $router->get('/users', ['uses' => 'UsersController@getAll']);
    $router->get('/users_seller', ['uses' => 'UsersController@getSellers']);
    $router->get('/users_buyer', ['uses' => 'UsersController@getBuyers']);
    $router->get('/users/{id}', ['uses' => 'UsersController@getUser']);
    $router->put('/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/users/{id}', ['uses' => 'UsersController@deleteUser']);
    $router->post('/users/logout', ['uses' => 'UsersController@logout']);

    // Category
    $router->get('/category', ['uses' => 'CategoryController@getAll']);
    $router->get('/category/{id}', ['uses' => 'CategoryController@getCategory']);
    $router->post('/category', ['uses' => 'CategoryController@createCategory']);
    $router->put('/category/{id}', ['uses' => 'CategoryController@updateCategory']);
    $router->delete('/category/{id}', ['uses' => 'CategoryController@deleteCategory']);

    // Product
    $router->get('/products', ['uses' => 'ProductController@getAll']);
    $router->get('/products/{id}', ['uses' => 'ProductController@getProduct']);
    $router->post('/products', ['uses' => 'ProductController@createProduct']);
    $router->put('/products/{id}', ['uses' => 'ProductController@updateProduct']);
    $router->delete('/products/{id}', ['uses' => 'ProductController@deleteProduct']);
    $router->get('/products_me', ['uses' => 'ProductController@getMeProducts']);
    $router->get('/products_by_category/{category_id}', ['uses' => 'ProductController@getProductsByCategory']);
    $router->post('/products_find', ['uses' => 'ProductController@getProductsFind']);


});