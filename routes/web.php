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
Route::redirect('/', '/login', 301);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->group(function(){
    Route::resource('order', 'Admin\OrderController');
    Route::resource('system/goodsmodel', 'Admin\GoodsModelController');
    Route::resource('system/goodscate', 'Admin\GoodsCateController');
    Route::get('showbill/{id}','Admin\OrderController@showbill')->middleware('role');
});