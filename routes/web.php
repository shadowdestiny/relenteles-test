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
    // return str_random(32);
    return response()->json(['hola' => str_random(32)], 200);
});


// We are using a Middleware that doesn't require configuration
// https://github.com/vluzrmos/lumen-cors
$router->group(['middleware' => []], function () use ($router) {
    $router->post('/users/login', ['uses' => 'UsersController@getToken']);
    $router->post('/users', ['uses' => 'UsersController@createUser']);
    $router->post('/token', ['uses' => 'PaymentsController@authStripe']);

    // Category
    $router->get('/category', ['uses' => 'CategoryController@getAll']);
    $router->get('/category/{id}', ['uses' => 'CategoryController@getCategory']);
});

$router->group(['middleware' => ['auth']], function () use ($router) {

    // Product
    $router->get('/products', ['uses' => 'ProductController@getAll']);
    $router->get('/products/{id}', ['uses' => 'ProductController@getProduct']);
    $router->get('/products_by_category/{category_id}', ['uses' => 'ProductController@getProductsByCategory']);
    $router->get('/products_by_seller/{seller_id}', ['uses' => 'ProductController@getProductsBySeller']);
    $router->post('/products_find', ['uses' => 'ProductController@getProductsFind']);

    // Users
    $router->post('/users/logout', ['uses' => 'UsersController@logout']);
    $router->get('/users_seller', ['uses' => 'UsersController@getSellers']);
    $router->get('/users', ['uses' => 'UsersController@getAll']);
    $router->get('/users_buyer', ['uses' => 'UsersController@getBuyers']);
    $router->get('/users/{id}', ['uses' => 'UsersController@getUser']);
    $router->put('/users/{id}', ['uses' => 'UsersController@updateUser']);
    $router->delete('/users/{id}', ['uses' => 'UsersController@deleteUser']);

    // Rate
    $router->get('/rate/{id}', ['uses' => 'RateController@getOneRate']);

});

$router->group(['middleware' => ['auth_buyer']], function () use ($router) {

    // Setting
    $router->get('/setting_buyer', ['uses' => 'SettingController@getAllSettingBuyer']);
    $router->get('/setting_buyer/{id}', ['uses' => 'SettingController@getOneSettingBuyer']);
    $router->post('/setting_buyer', ['uses' => 'SettingController@checkSettingBuyer']);

    // wish list
    $router->post('/wish_list', ['uses' => 'WishListController@createList']);
    $router->delete('/wish_list/{id}', ['uses' => 'WishListController@deleteList']);
    $router->get('/wish_list', ['uses' => 'WishListController@getAllWishList']);
    $router->get('/wish_list/{id}', ['uses' => 'WishListController@getWishList']);

    // order
    $router->get('/orders', ['uses' => 'SellerSaleController@getByBuyer']);
    $router->get('/orders/{id}', ['uses' => 'SellerSaleController@getFindByBuyer']);

    // products
    $router->get('/products_of_buyer', ['uses' => 'ProductController@getByBuyer']);
    $router->post('/products_of_buyer_find', ['uses' => 'ProductController@getProductsFindByBuyer']);

    // rate
    $router->get('/rate_me', ['uses' => 'RateController@getMe']);
    $router->post('/rate', ['uses' => 'RateController@createRating']);

    // Stripe Subcriptions
    $router->post('/payment', ['uses' => 'PaymentsController@createSubscription']);
    $router->post('/payment_product', ['uses' => 'PaymentsController@createPayment']);

    // Favorite
    $router->post('/favorite', ['uses' => 'FavoriteController@createFavorite']);
    $router->get('/favorite', ['uses' => 'FavoriteController@getAll']);
    $router->delete('/favorite/{id}', ['uses' => 'FavoriteController@deleteFavorite']);

    // Car
    $router->post('/car', ['uses' => 'CarController@createCar']);
    $router->get('/car', ['uses' => 'CarController@getAll']);
    $router->delete('/car/{id}', ['uses' => 'CarController@deleteCar']);

});

$router->group(['middleware' => ['auth_seller']], function () use ($router) {

    // Setting
    $router->get('/setting_seller', ['uses' => 'SettingController@getAllSettingSeller']);
    $router->get('/setting_seller/{id}', ['uses' => 'SettingController@getOneSettingSeller']);
    $router->post('/setting_seller', ['uses' => 'SettingController@checkSettingSeller']);

    // order
    $router->get('/sales', ['uses' => 'SellerSaleController@getBySeller']);
    $router->get('/sales/{id}', ['uses' => 'SellerSaleController@getFindBySeller']);

    // Category
    $router->post('/category', ['uses' => 'CategoryController@createCategory']);
    $router->put('/category/{id}', ['uses' => 'CategoryController@updateCategory']);
    $router->delete('/category/{id}', ['uses' => 'CategoryController@deleteCategory']);

    // Product
    $router->post('/products', ['uses' => 'ProductController@createProduct']);
    $router->put('/products/{id}', ['uses' => 'ProductController@updateProduct']);
    $router->delete('/products/{id}', ['uses' => 'ProductController@deleteProduct']);
    $router->get('/products_me', ['uses' => 'ProductController@getMeProducts']);

});