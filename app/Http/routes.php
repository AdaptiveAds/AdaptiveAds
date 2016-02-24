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
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Landing page
Route::get('dashboard', ['middleware' => 'auth', 'uses' => 'DashboardController@index']);

// Playlist pages
Route::post('dashboard/playlist/{playlistID}/add', ['as' => 'dashboard.playlist.add', 'uses' => 'PlaylistController@addExistingAdvert']);
Route::post('dashboard/playlist/{playlistID}/remove', ['as' => 'dashboard.playlist.remove', 'uses' => 'PlaylistController@removeAdvert']);
Route::post('dashboard/playlist/{playlistID}/updateIndexes', ['as' => 'dashboard.playlist.updateIndexes', 'uses' => 'PlaylistController@updateIndexes']);
Route::resource('dashboard/playlist', 'PlaylistController', ['except' => ['create']]);
Route::post('dashboard/playlist/filter', ['as' => 'dashboard.playlist.filter', 'uses' => 'PlaylistController@filter']);
Route::post('dashboard/settings/playlist/{playlistID}/toggleDeleted', ['as' => 'dashboard.playlist.toggleDeleted', 'uses' => 'PlaylistController@toggleDeleted']);

// Advert pages
Route::post('dashboard/advert/{playlistID}/removeMode', ['as' => 'dashboard.advert.removeMode', 'uses' => 'AdvertController@removeMode']);
Route::post('dashboard/advert/{playlistID}/select', ['as' => 'dashboard.advert.select', 'uses' => 'AdvertController@selectForPlaylist']);
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::resource('dashboard/advert', 'AdvertController');
Route::post('dashboard/advert/filter', ['as' => 'dashboard.advert.filter', 'uses' => 'AdvertController@filter']);
Route::post('dashboard/advert/{advert}/toggleDeleted', ['as' => 'dashboard.advert.toggleDeleted', 'uses' => 'AdvertController@toggleDeleted']);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);

// Settings
Route::get('dashboard/settings', ['middleware' => 'auth', 'uses' => 'PlaylistController@index']);

// Users routes
Route::resource('dashboard/settings/users', 'UserController');
Route::post('dashboard/settings/users/filter', ['as' => 'dashboard.settings.users.filter', 'uses' => 'UserController@filter']);
Route::post('dashboard/settings/users/{users}/toggleDeleted', ['as' => 'dashboard.settings.users.toggleDeleted', 'uses' => 'UserController@toggleDeleted']);

// Locations routes
Route::resource('dashboard/settings/locations', 'LocationController');
Route::post('dashboard/settings/locations/filter', ['as' => 'dashboard.settings.locations.filter', 'uses' => 'LocationController@filter']);
Route::post('dashboard/settings/locations/{locations}/toggleDeleted', ['as' => 'dashboard.settings.locations.toggleDeleted', 'uses' => 'LocationController@toggleDeleted']);

// Department routes
Route::resource('dashboard/settings/departments', 'DepartmentController');
Route::post('dashboard/settings/departments/filter', ['as' => 'dashboard.settings.departments.filter', 'uses' => 'DepartmentController@filter']);
Route::post('dashboard/settings/departments/{departments}/toggleDeleted', ['as' => 'dashboard.settings.departments.toggleDeleted', 'uses' => 'DepartmentController@toggleDeleted']);

// Screens routes
Route::resource('dashboard/settings/screens', 'ScreenController');
Route::post('dashboard/settings/screens/filter', ['as' => 'dashboard.settings.screens.filter', 'uses' => 'ScreenController@filter']);
Route::post('dashboard/settings/screens/{screens}/toggleDeleted', ['as' => 'dashboard.settings.screens.toggleDeleted', 'uses' => 'ScreenController@toggleDeleted']);

// Templates routes
Route::resource('dashboard/settings/templates', 'TemplateController');
Route::post('dashboard/settings/templates/filter', ['as' => 'dashboard.settings.templates.filter', 'uses' => 'TemplateController@filter']);
Route::post('dashboard/settings/templates/{templates}/toggleDeleted', ['as' => 'dashboard.settings.templates.toggleDeleted', 'uses' => 'TemplateController@toggleDeleted']);

// Skins routes
Route::resource('dashboard/settings/skins', 'SkinController');
Route::post('dashboard/settings/skins/filter', ['as' => 'dashboard.settings.skins.filter', 'uses' => 'SkinController@filter']);
Route::post('dashboard/settings/skins/{skins}/toggleDeleted', ['as' => 'dashboard.settings.skins.toggleDeleted', 'uses' => 'SkinController@toggleDeleted']);


// Serve routes
Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

// event listener to debug SQL
Event::listen('illuminate.query', function($query)
{
    // Outputs SQL queries if enabled
    //var_dump($query);
});
