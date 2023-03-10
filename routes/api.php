<?php

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

//demo 暫時用不到註解一下
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//商店
Route::group(['prefix' => 'stores'], function () {
    Route::get('list', 'StoresController@list')->name('api.stores.list');
    Route::get('/show/{id}','StoresController@show')->name('api.stores.show');
    Route::post('/store','StoresController@store')->name('api.stores.store');
    Route::put('/update/{id}','StoresController@update')->name('api.stores.update');
});

//食物
Route::group(['prefix' => 'foods'], function () {
    Route::get('list', 'FoodsController@list')->name('api.foods.list');
    Route::get('/show/{id}','FoodsController@show')->name('api.foods.show');
    Route::post('/store','FoodsController@store')->name('api.foods.store');
    Route::put('/update/{id}','FoodsController@update')->name('api.foods.update');
});
