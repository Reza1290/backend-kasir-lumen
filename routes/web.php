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
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
   
    
    $router->group(['middleware' => 'auth:api'], function () use ($router){     
        $router->post('me', 'AuthController@me');
        $router->get('products', 'ProductController@index');
        $router->post('products', 'ProductController@store');
        $router->get('products/{id}', 'ProductController@show');
        $router->put('products/{id}', 'ProductController@update');
        $router->delete('products/{id}', 'ProductController@destroy');


        $router->get('product_stocks', 'ProductStockController@index');
        $router->post('product_stocks', 'ProductStockController@store');
        $router->get('product_stocks/{id}', 'ProductStockController@show');
        $router->put('product_stocks/{id}', 'ProductStockController@update');
        $router->delete('product_stocks/{id}', 'ProductStockController@destroy');

        $router->get('product_categories', 'ProductCategoryController@index');
        $router->get('product_categories_all', 'ProductCategoryController@indexall');
        $router->post('product_categories', 'ProductCategoryController@store');
        $router->get('product_categories/{id}', 'ProductCategoryController@show');
        $router->put('product_categories/{id}', 'ProductCategoryController@update');
        $router->delete('product_categories/{id}', 'ProductCategoryController@destroy');

        $router->get('transactions', 'TransactionController@index');
        $router->post('transactions', 'TransactionController@store');
        $router->get('transaction_items', 'TransactionItemController@index');
    });
});