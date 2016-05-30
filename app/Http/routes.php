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

// Landing page
Route::get('/', 'Frontend@index');

// Team and contact routes
Route::get('contact', 'ContactController@index');
Route::get('team', 'TeamController@index');
Route::get('faq', 'FAQController@index');

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Landing page
Route::get('dashboard', ['as' => 'dashboard', 'middleware' => 'auth', 'uses' => 'DashboardController@index']);

// Playlist pages
Route::resource('dashboard/playlist', 'PlaylistController', ['except' => ['create']]);
Route::post('dashboard/playlist/{playlistID}/updateIndexes', ['as' => 'dashboard.playlist.updateIndexes', 'uses' => 'PlaylistController@updateIndexes']);
Route::post('dashboard/playlist/filter', ['as' => 'dashboard.playlist.filter', 'uses' => 'PlaylistController@filter']);
Route::post('dashboard/playlist/process', ['as' => 'dashboard.playlist.process', 'uses' => 'PlaylistController@process']);

// Advert pages
Route::resource('dashboard/advert', 'AdvertController');
Route::post('dashboard/advert/{advertID}/updateIndexes', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateIndexes']);
Route::post('dashboard/advert/filter', ['as' => 'dashboard.advert.filter', 'uses' => 'AdvertController@filter']);
Route::post('dashboard/advert/{advertID}/updateBackground', ['as' => 'dashboard.advert.updateIndexes', 'uses' => 'AdvertController@updateBackground']);

// Page pages
Route::resource('dashboard/advert/{adID}/page', 'PageController', ['except' => ['index', 'edit']]);
Route::post('dashboard/advert/{advertID}/page/{pageID}/removeMedia', ['as' => 'dashboard.advert.page.removeMedia', 'uses' => 'PageController@removeMedia']);

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

// backgrounds routes
Route::resource('dashboard/settings/backgrounds', 'BackgroundController');
Route::post('dashboard/settings/backgrounds/filter', ['as' => 'dashboard.settings.backgrounds.filter', 'uses' => 'BackgroundController@filter']);

// Privileges routes
Route::resource('dashboard/settings/privileges', 'PrivilegeController');
Route::post('dashboard/settings/privileges/process', ['as' => 'dashboard.settings.privileges.process', 'uses' => 'PrivilegeController@process']);
// Serve routes
Route::get('serve/{screenId}', 'ServeController@show');
Route::post('serve/{screenID}', 'ServeController@sync');

// event listener to debug SQL
Event::listen('illuminate.query', function($query)
{
    // Outputs SQL queries if enabled
    //var_dump($query);
});
