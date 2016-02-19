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
Route::post('dashboard/playlist/{playlistID}/add', ['as' => 'dashboard.playlist.add', 'uses' => 'PlaylistController@addExistingAdvert']);
Route::post('dashboard/playlist/{playlistID}/remove', ['as' => 'dashboard.playlist.remove', 'uses' => 'PlaylistController@removeAdvert']);
Route::post('dashboard/playlist/{playlistID}/updateIndexes', ['as' => 'dashboard.playlist.updateIndexes', 'uses' => 'PlaylistController@updateIndexes']);
Route::resource('dashboard/playlist', 'PlaylistController', ['except' => ['create']]);
Route::post('dashboard/playlist/process', ['as' => 'dashboard.playlist.process', 'uses' => 'PlaylistController@process']);

// Advert pages
Route::post('dashboard/advert/{playlistID}/removeMode', ['as' => 'dashboard.advert.removeMode', 'uses' => 'AdvertController@removeMode']);
Route::post('dashboard/advert/{playlistID}/select', ['as' => 'dashboard.advert.select', 'uses' => 'AdvertController@selectForPlaylist']);
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::resource('dashboard/advert', 'AdvertController');
Route::post('dashboard/advert/process', ['as' => 'dashboard.advert.process', 'uses' => 'AdvertController@process']);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);

// Settings
Route::get('dashboard/settings', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);

// Users routes
Route::resource('dashboard/settings/users', 'UserController');
Route::post('dashboard/settings/users', ['as' => 'dashboard.settings.users.process', 'uses' => 'UserController@process']);
Route::post('dashboard/settings/users/{users}/toggleDeleted', ['as' => 'dashboard.settings.users.toggleDeleted', 'uses' => 'UserController@toggleDeleted']);

// Locations routes
Route::resource('dashboard/settings/locations', 'LocationController');
Route::post('dashboard/settings/locations/process', ['as' => 'dashboard.settings.locations.process', 'uses' => 'LocationController@process']);

// Department routes
Route::resource('dashboard/settings/departments', 'DepartmentController');
Route::post('dashboard/settings/departments/process', ['as' => 'dashboard.settings.departments.process', 'uses' => 'DepartmentController@process']);

// Screens routes
Route::resource('dashboard/settings/screens', 'ScreenController');
Route::post('dashboard/settings/screens/process', ['as' => 'dashboard.settings.screens.process', 'uses' => 'ScreenController@process']);
Route::post('dashboard/settings/screens/{screens}/toggleDeleted', ['as' => 'dashboard.settings.screens.toggleDeleted', 'uses' => 'ScreenController@toggleDeleted']);

// Templates routes
Route::resource('dashboard/settings/templates', 'TemplateController');
Route::post('dashboard/settings/templates/process', ['as' => 'dashboard.settings.templates.process', 'uses' => 'TemplateController@process']);
Route::post('dashboard/settings/templates/{templates}/toggleDeleted', ['as' => 'dashboard.settings.templates.toggleDeleted', 'uses' => 'TemplateController@toggleDeleted']);

// Serve routes
Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

// event listener to debug SQL
Event::listen('illuminate.query', function($query)
{
    // Outputs SQL queries if enabled
    //var_dump($query);
});
