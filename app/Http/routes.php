<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
    $laravel = app();
    $version = $laravel::VERSION;
    return $version;
});

//Route::auth();

Route::get('/home', 'IndexController@index');
Route::group(['prefix' => 'v1'], function(){
//    Route::resource('login', 'AuthenticateController', ['only' => ['index']]);
    Route::post('login', 'AuthenticateController@index');
    Route::post('register', 'AuthenticateController@register');
    Route::get('show','AuthenticateController@show');
    Route::get('list-token', 'AuthenticateController@listToken');
});