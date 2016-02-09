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

// Landing page TODO change
Route::get('/', function () {
    return view('welcome');
});

// Team and contact routes
Route::get('contact', 'ContactController@index');
Route::get('team', 'TeamController@index');

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
Route::post('dashboard/playlist', ['as' => 'dashboard.playlist.process', 'uses' => 'PlaylistController@process']);

// Advert pages
Route::post('dashboard/advert/{playlistID}', ['as' => 'dashboard.advert.select', 'uses' => 'AdvertController@selectForPlaylist']);
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::resource('dashboard/advert', 'AdvertController', ['except' => ['edit', 'update']]);
Route::post('dashboard/advert', ['as' => 'dashboard.advert.process', 'uses' => 'AdvertController@process']);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);

// Settings
Route::get('dashboard/settings', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);

// Users routes
Route::get('dashboard/settings/users', ['middleware' => 'auth', 'uses' => 'UserController@index']);
Route::post('dashboard/settings/users', ['as' => 'dashboard.settings.users.process', 'uses' => 'UserController@process']);

// Locations routes
Route::get('dashboard/settings/locations', ['middleware' => 'auth', 'uses' => 'LocationController@index']);
Route::post('dashboard/settings/locations', ['as' => 'dashboard.settings.locations.process', 'uses' => 'LocationController@process']);

// Department routes
Route::get('dashboard/settings/departments', ['middleware' => 'auth', 'uses' => 'DepartmentController@index']);
Route::post('dashboard/settings/departments', ['as' => 'dashboard.settings.departments.process', 'uses' => 'DepartmentController@process']);

// Screens routes
Route::get('dashboard/settings/screens', ['middleware' => 'auth', 'uses' => 'ScreenController@index']);
Route::post('dashboard/settings/screens', ['as' => 'dashboard.settings.screens.process', 'uses' => 'ScreenController@process']);

// Templates routes
Route::get('dashboard/settings/templates', ['middleware' => 'auth', 'uses' => 'TemplateController@index']);
Route::post('dashboard/settings/templates', ['as' => 'dashboard.settings.templates.process', 'uses' => 'TemplateController@process']);

// Serve routes
Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

// event listener to debug SQL
Event::listen('illuminate.query', function($query)
{
    // Outputs SQL queries if enabled
    //var_dump($query);
});
