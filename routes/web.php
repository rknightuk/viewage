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

Route::get('foo-bar', function() {
	return view('welcome');
});

Route::get('/collect', 'CollectController@collect');

Route::get('/dashboard', 'DashboardController@index')->middleware('auth');
Route::get('/sites', 'SiteController@index')->middleware('auth');
Route::get('/sites/new', 'SiteController@new')->middleware('auth');
Route::post('/sites/new', 'SiteController@store')->middleware('auth');
Route::get('/sites/{siteId}', 'SiteController@show')->middleware('auth');

Auth::routes(['register' => false]);
