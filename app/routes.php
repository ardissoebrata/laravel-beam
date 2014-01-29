<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function() {
	
	Route::get('/', function()
	{
		return View::make('demos/hello');
	});

	Route::controller('demos', 'DemosController');
	Route::controller('resource', 'ResourceController');
	Route::controller('role', 'RoleController');
	Route::controller('rule', 'RuleController');
	
	Route::get('user/index', 'UserController@getIndex');
	Route::get('user/edit/{id}', 'UserController@getEdit');
	Route::post('user/edit', 'UserController@postEdit');
	Route::post('user/delete/{id}', 'UserController@postDelete');
	
});

// Confide RESTful route
Route::get('user/confirm/{code}', 'UserController@getConfirm');
Route::get('user/reset/{token}', 'UserController@getReset');
Route::get('user/login', 'UserController@getLogin');
Route::post('user/login', 'UserController@postLogin');
Route::get('user/logout', 'UserController@getLogout');
Route::get('user/create', 'UserController@getCreate');
Route::post('user/create', 'UserController@postCreate');

