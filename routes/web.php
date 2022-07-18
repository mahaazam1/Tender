<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'],function(){

    Route::get('dashboard','Admin\UsersController@getSellers');

    Route::get('category','Admin\CategoryController@index');
    Route::get('category/create','Admin\CategoryController@create');
    Route::post('category/store','Admin\CategoryController@store');
    Route::post('category/destroy/{id}','Admin\CategoryController@destroy');
    Route::get('category/edit/{id}','Admin\CategoryController@edit');
    Route::post('category/update/{id}','Admin\CategoryController@update');

    Route::view('test','test')->name('test');
    Route::get('product/serachResult','Admin\ProductController@searchProduct');

    Route::get('approval-of-products','Admin\ProductController@index');
    Route::get('all-products','Admin\ProductController@allProducts');
    Route::get('products/approved','Admin\ProductController@acceptedProducts');

    Route::post('products/disapproval/{id}','Admin\ProductController@destroy');
    Route::post('products/approval/{id}','Admin\ProductController@approvalProduct');

    
    });
