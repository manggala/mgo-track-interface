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

Route::group(['prefix' =>'/products'], function(){
	Route::get('/', "ProductController@index");
});
Route::group(['prefix' => '/tracking'], function(){
	Route::post('store', function(){
		return response('', 200);
	});
});