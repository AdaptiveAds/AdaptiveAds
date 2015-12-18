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

Route::get('/', function () {
    return view('welcome');
});

Route::get('contact', ['middleware' => 'auth', 'uses' => 'ContactController@index']);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Landing page
Route::get('dashboard', ['middleware' => 'auth', 'uses' => 'DashboardController@index']);

// Advert pages
Route::get('dashboard/advert', ['middleware' => 'auth', 'uses' => 'AdvertController@index']);
Route::get('dashboard/advert/{id}', ['middleware' => 'auth', 'uses' => 'AdvertController@index']);

// Page pages
Route::get('dashboard/page', ['middleware' => 'auth', 'uses' => 'PageController@index']);
Route::get('dashboard/page/{id}', ['middleware' => 'auth', 'uses' => 'PageController@index']);

// Playlist pages
Route::get('dashboard/playlist', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);
Route::get('dashboard/playlist/{id}', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);

// Settings
Route::get('dashboard/settings', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);
Route::get('dashboard/settings/users', ['middleware' => 'auth', 'uses' => 'UsersController@index']);
Route::get('dashboard/settings/locations', ['middleware' => 'auth', 'uses' => 'LocationsController@index']);
Route::get('dashboard/settings/screens', ['middleware' => 'auth', 'uses' => 'ScreensController@index']);

Route::get('serve/{id}', ['middleware' => 'auth', 'uses' => 'PageController@show']);
