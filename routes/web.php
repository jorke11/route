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


Route::group(['namespace' => 'Api'], function () {
    Route::post('/user/login', 'UserController@login');
    Route::post('/newStakeholder', 'UserController@newStakeholder');
    Route::get('/details', 'UserController@details')->middleware('auth:api');
    
    Route::post('/newPark', 'ParkController@newPark')->middleware('auth:api');
    
    Route::put('/editPark/{id}/edit', 'ParkController@update')->middleware('auth:api');
    Route::delete('park/{id}', 'ParkController@delete')->middleware('auth:api');
    Route::get('/getPark/{id}', 'ParkController@getPark')->middleware('auth:api');
    Route::get('getParks', 'ParkController@getParks')->middleware('auth:api');
//    Route::resource("binnacle", "BinnacleController");
    
    Route::post('/reservePark', 'OrdersController@reservePark')->middleware('auth:api');
    Route::get('/getOrders', 'OrdersController@getOrders')->middleware('auth:api');
    Route::post('cancel', 'OrdersController@cancelOrder')->middleware('auth:api');
    Route::post('confirm', 'OrdersController@ConfirmOrder')->middleware('auth:api');
});

