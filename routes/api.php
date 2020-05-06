<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Login/registration - public
Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
//product browsing - public
Route::get('/products', 'ProductController@index');
//product details - public
Route::get('/products/{product}', 'ProductController@show');
Route::get('/categories','ProductController@indexCategories');

Route::group(['middleware' => ['auth:api','isNotBanned']], function(){
    //Show profile
    Route::get('/users','UserController@index');
    //Show orders (only for user)
    Route::get('/orders', 'OrderController@index');
    //Show order details
    Route::get('/orders/{id}','OrderController@show');

    //Place order
    Route::post('/order/place','OrderController@place');

    //Basket control
    Route::get('/basket','BasketController@index');
    //id= product id, indicates id of product to ba added to basket
    Route::post('/products/{product}/to-basket', 'BasketController@add');
    //change amount of product units in basket
    Route::patch('/basket/{product}/{amount}', 'BasketController@update');
    //empty the basket
    Route::delete('/basket', 'BasketController@delete');

    Route::middleware('isAdmin')->group(function()
    {
        //Monitor user orders and allow to simulate delivery
        Route::get('/users/{user}/orders','UserController@index');
        //Allow to simulate delivery of given order
        Route::patch('/orders/{id}/deliver','OrderController@deliverOrder');
        //Allow to view all orders
        Route::get('/orders/all', 'OrderController@indexAll');

        Route::get('/users/{id}','UserController@show');
        //User control
        Route::patch('/users/{id}/ban', 'UserController@ban');
        Route::patch('/users/{id}/unban', 'UserController@unban');
        Route::patch('/users/{id}/admin', 'UserController@admin');
        Route::patch('/users/{id}/unadmin', 'UserController@unadmin');
        //Email notifications control
        Route::post('/users/{id}/notify', 'UserController@notifyOne');
        Route::post('/users/notify', 'UserController@notifyAll');
        //Product C,U,D, with file upload
        Route::delete('/products/{id}', 'ProductController@delete');
        Route::post('/products', 'ProductController@create');
        Route::patch('/products/{id}', 'ProductController@update');
        Route::post('/upload-file', 'FileController@uploadFile');
    });
});
