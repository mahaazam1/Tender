<?php

use Illuminate\Http\Request;

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
Auth::routes();

Route::view('error','errors/error')->name('error');

Route::group(['prefix' => 'seller'],function(){
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');

});
Route::group(['prefix' => 'seller', 'middleware' => 'admin.auth:seller-api'],function(){
    Route::post('userProfile', 'Api\AuthController@userProfile');
    Route::post('updateProfile', 'Api\AuthController@updateProfile');
    Route::post('logout', 'Api\AuthController@logout');

    Route::post('address/create', 'Api\AddressController@create');
    Route::post('address/update', 'Api\AddressController@update');
    Route::post('address/delete', 'Api\AddressController@delete');
    Route::get('myAddress', 'Api\AddressController@myAddress');

    Route::post('products/create', 'Api\ProductController@create');
    Route::post('products/update', 'Api\ProductController@update');
    Route::post('products/delete', 'Api\ProductController@delete');
    Route::get('products/searchResult', 'Api\ProductController@searchProduct');
    Route::get('products/lastProducts', 'Api\ProductController@lastProducts');
    Route::get('productsOffers', 'Api\ProductController@productsOffers');
    Route::get('products', 'Api\ProductController@products');
    Route::get('myProducts', 'Api\ProductController@myProducts');


    Route::post('SavedProducts/create', 'Api\SavedProductsController@saveProduct');
    Route::post('SavedProducts/delete', 'Api\SavedProductsController@delete');
    Route::get('SavedProducts', 'Api\SavedProductsController@savedProducts');

    Route::post('purchaseCart/create', 'Api\PurchaseCartController@create');
    Route::post('purchaseCart/update', 'Api\PurchaseCartController@update');
    Route::post('purchaseCart/delete', 'Api\PurchaseCartController@delete');
    Route::post('purchaseCart/buying', 'Api\PurchaseCartController@buying');
    Route::get('purchaseCart', 'Api\PurchaseCartController@purchaseCart');
    Route::get('getMyOrder', 'Api\PurchaseCartController@getMyOrder');

    Route::get('order/getOrders', 'Api\SalesCartController@getOrders');
    Route::post('order/orderCompleted', 'Api\SalesCartController@orderCompleted');

    Route::get('searchResult', 'Api\Buyer\SellerController@searchSeller');
    Route::get('mayLikeSellers', 'Api\Buyer\SellerController@mayLikeSellers');
    Route::get('newSellers', 'Api\Buyer\SellerController@newSellers');
    Route::get('getSellers', 'Api\Buyer\SellerController@getSellers');



    Route::get('categories', 'Api\CategoryController@categories');


    Route::post('follow','Api\FollowingController@follow');
    Route::post('unFollow','Api\FollowingController@unfollow');
    Route::get('following','Api\FollowingController@following');
    Route::get('followers','Api\FollowingController@followers');

});

Route::group(['prefix' => 'buyer'],function(){
    Route::post('login', 'Api\Buyer\AuthController@login');
    Route::post('register', 'Api\Buyer\AuthController@register');

});

Route::group(['prefix' => 'buyer', 'middleware' => 'admin.auth:buyer-api'],function(){
    Route::post('profile', 'Api\Buyer\AuthController@profile');
    Route::post('updateProfile', 'Api\Buyer\AuthController@updateProfile');
    Route::post('logout', 'Api\Buyer\AuthController@logout');

    Route::post('address/create', 'Api\Buyer\AddressController@create');
    Route::post('address/update', 'Api\Buyer\AddressController@update');
    Route::post('address/delete', 'Api\Buyer\AddressController@delete');
    Route::get('myAddress', 'Api\Buyer\AddressController@myAddress');

    Route::post('cart/create', 'Api\Buyer\CartController@addToCart');
    Route::post('cart/update', 'Api\Buyer\CartController@update');
    Route::post('cart/delete', 'Api\Buyer\CartController@delete');
    Route::post('cart/buying', 'Api\Buyer\CartController@buying');
    Route::get('cart', 'Api\Buyer\CartController@cart');

    Route::get('getMyOrder', 'Api\Buyer\CartController@getMyOrder');


    Route::post('savedProducts/create', 'Api\Buyer\SavedProductsController@saveProduct');
    Route::post('savedProducts/delete', 'Api\Buyer\SavedProductsController@delete');
    Route::get('savedProducts', 'Api\Buyer\SavedProductsController@savedProducts');

    Route::post('follow','Api\FollowingController@follow');
    Route::post('unFollow','Api\FollowingController@unfollow');
    Route::get('following','Api\FollowingController@following');

    Route::get('searchResult', 'Api\Buyer\SellerController@searchSeller');
    Route::get('mayLikeSellers', 'Api\Buyer\SellerController@mayLikeSellers');
    Route::get('newSellers', 'Api\Buyer\SellerController@newSellers');
    Route::get('getSellers', 'Api\Buyer\SellerController@getSellers');

    Route::get('categories', 'Api\CategoryController@categories');

    Route::get('products/searchResult', 'Api\ProductController@searchProduct');
    Route::get('products/lastProducts', 'Api\ProductController@lastProducts');
    Route::get('productsOffers', 'Api\ProductController@productsOffers');
    Route::get('products', 'Api\ProductController@products');


    
    

});









