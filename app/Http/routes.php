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

// Playlist pages
Route::get('dashboard/playlist/{playlistID}/{advertID}', ['as' => 'dashboard.playlist.add', 'uses' => 'PlaylistController@addExistingAdvert']);
Route::get('dashboard/playlist/{playlistID}/{advertID}/remove', ['as' => 'dashboard.playlist.remove', 'uses' => 'PlaylistController@removeAdvert']);
Route::post('dashboard/playlist/{playlistID}/remove', ['as' => 'dashboard.playlist.removeMode', 'uses' => 'PlaylistController@removeMode']);
Route::post('dashboard/playlist/{playlistID}/updateIndexes', ['as' => 'dashboard.playlist.updateIndexes', 'uses' => 'PlaylistController@updateIndexes']);
Route::resource('dashboard/playlist', 'PlaylistController', ['except' => ['create', 'edit', 'update']]);

// Advert pages
Route::post('dashboard/advert/{playlistID}', ['as' => 'dashboard.advert.select', 'uses' => 'AdvertController@selectForPlaylist']);
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::resource('dashboard/advert', 'AdvertController', ['except' => ['edit', 'update']]);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);

// Settings
Route::get('dashboard/settings', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);
Route::get('dashboard/settings/users', ['middleware' => 'auth', 'uses' => 'UserController@index']);
Route::get('dashboard/settings/locations', ['middleware' => 'auth', 'uses' => 'LocationController@index']);
Route::get('dashboard/settings/screens', ['middleware' => 'auth', 'uses' => 'ScreenController@index']);

Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

Event::listen('illuminate.query', function($query)
{
    //var_dump($query);
});
