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

// Advert pages
Route::post('dashboard/advert/{playlistID}/removeMode', ['as' => 'dashboard.advert.removeMode', 'uses' => 'AdvertController@removeMode']);
Route::post('dashboard/advert/{playlistID}/select', ['as' => 'dashboard.advert.select', 'uses' => 'AdvertController@selectForPlaylist']);
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::resource('dashboard/advert', 'AdvertController');
Route::post('dashboard/advert/filter', ['as' => 'dashboard.advert.filter', 'uses' => 'AdvertController@filter']);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);

// Users routes
Route::resource('dashboard/settings/users', 'UserController');
Route::post('dashboard/settings/users/filter', ['as' => 'dashboard.settings.users.filter', 'uses' => 'UserController@filter']);
// Locations routes
Route::resource('dashboard/settings/locations', 'LocationController');
Route::post('dashboard/settings/locations/filter', ['as' => 'dashboard.settings.locations.filter', 'uses' => 'LocationController@filter']);
// Department routes
Route::resource('dashboard/settings/departments', 'DepartmentController');
Route::post('dashboard/settings/departments/filter', ['as' => 'dashboard.settings.departments.filter', 'uses' => 'DepartmentController@filter']);

// Screens routes
Route::resource('dashboard/settings/screens', 'ScreenController');
Route::post('dashboard/settings/screens/filter', ['as' => 'dashboard.settings.screens.filter', 'uses' => 'ScreenController@filter']);

// Templates routes
Route::resource('dashboard/settings/templates', 'TemplateController');
Route::post('dashboard/settings/templates/filter', ['as' => 'dashboard.settings.templates.filter', 'uses' => 'TemplateController@filter']);

// Skins routes
Route::resource('dashboard/settings/skins', 'SkinController');
Route::post('dashboard/settings/skins/filter', ['as' => 'dashboard.settings.skins.filter', 'uses' => 'SkinController@filter']);

// Privileges routes
Route::resource('dashboard/settings/privileges', 'PrivilegeController');
Route::post('dashboard/settings/privileges/filter', ['as' => 'dashboard.settings.privileges.filter', 'uses' => 'PrivilegeController@filter']);
Route::post('dashboard/settings/privileges/addMode', ['as' => 'dashboard.settings.privileges.addMode', 'uses' => 'PrivilegeController@addMode']);
Route::post('dashboard/settings/privileges/add', ['as' => 'dashboard.settings.privileges.add', 'uses' => 'PrivilegeController@addUser']);
Route::post('dashboard/settings/privileges/removeMode', ['as' => 'dashboard.settings.privileges.removeMode', 'uses' => 'PrivilegeController@removeMode']);
Route::post('dashboard/settings/privileges/remove', ['as' => 'dashboard.settings.privileges.remove', 'uses' => 'PrivilegeController@removeUser']);

// Serve routes
Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

// event listener to debug SQL
Event::listen('illuminate.query', function($query)
{
    // Outputs SQL queries if enabled
    //var_dump($query);
});
