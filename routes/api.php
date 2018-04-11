<?php

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
Route::middleware('auth:api', 'role')->group(function() {
    //cate
    Route::get('getgoodscate', 'Api\GoodsCateController@getAllCates');
    Route::post('updategoodscate', 'Api\GoodsCateController@updateCates');
    Route::post('delgoodscate', 'Api\GoodsCateController@delCates');
    Route::post('addgoodscate', 'Api\GoodsCateController@addCates');

    //model
    Route::resource('goodsmodel', 'Api\GoodsModelController');
    Route::post('modellist', 'Api\GoodsModelController@modellist');

    //order
    Route::resource('order', 'Api\OrdersController');
    Route::post('orderinfobybill', 'Api\OrdersController@orderinfobybill');

    //pay
    Route::post('pay', 'Api\PayController@pay');

//    Route::get('getmodellist', 'Api\GoodsCateController@getmodellist');
//    Route::put('user/active', 'Api\UserController@updateActive');
//    Route::apiResources([
//        'user' => 'Api\UserController',
//        'menu' => 'Api\MenuController',
//        'role' => 'Api\RoleController',
//        'permission' => 'Api\PermissionController',
//    ]);
});
