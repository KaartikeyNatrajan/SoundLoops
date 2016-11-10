<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index');

Route::get('favourites', 'HomeController@getFavourites');

Route::get('my-sounds', 'HomeController@getUserSounds');

Route::get('library', 'HomeController@getLibrary');

Route::get('api/favourites', 'HomeController@apiGetFavourites');

Route::get('api/my-sounds', 'HomeController@apiGetUserSounds');

Route::get('api/library', 'HomeController@apiGetLibrary');
