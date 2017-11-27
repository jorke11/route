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
    Route::post('/newPark', 'UserController@newPark');
    Route::put('/editPark/{id}/edit', 'UserController@update');
    Route::get('/details', 'UserController@details')->middleware('auth:api');
    Route::get('/getPark/{id}', 'UserController@getPark')->middleware('auth:api');
    Route::resource("binnacle", "BinnacleController");
});
