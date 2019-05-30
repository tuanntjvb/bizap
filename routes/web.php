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

Auth::routes();
Route::group(['as' => 'dashboard::'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
    Route::get('/profile', ['as' => 'profile', 'profile' => 'HomeController@profile']);
    Route::get('/home', 'HomeController@index');
});
##AUTO_INSERT_ROUTE##