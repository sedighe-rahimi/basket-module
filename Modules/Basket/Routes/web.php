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

Route::get('/basket/index/{cacheName}', 'BasketController@all')->name('basket.index');
Route::get('/basket/add/{cacheName}/{id}' , 'BasketController@addCount')->name('basket.addCount');
Route::get('/basket/decrease/{decCount}/{cacheName}/{id}' , 'BasketController@decreaseCount')->name('basket.decCount');

