<?php

/*
Route::get('/', function()
{
new helpers\forms\form\Login;
)};
*/

Route::get('/', 'Vedette\controllers\AdminController@index');

Route::get('/', array(
	'as' => 'home',
	'uses' => 'Vedette\controllers\AdminController@index'
	));

Route::get('/404', array(
	'as' => 'notfound',
	'uses' => 'Vedette\controllers\AdminController@notfound'
	));

Route::group(array('before' => 'guest'), function()
{
	Route::get('register', array(
		'as' =>'register',
		'uses' => 'Vedette\controllers\UserController@create'
		));
	Route::resource('user', 'Vedette\controllers\UserController',
		array('only' => array('create', 'store')
		));

	Route::get('password/reset', array(
		'as' => 'password.remind',
		'uses' => 'Vedette\controllers\PasswordController@remind'
		));
	Route::post('password/reset', array(
		'before' => 'csrf',
		'as' => 'password.request',
		'uses' => 'Vedette\controllers\PasswordController@request'
		));
	Route::get('password/reset/{token}', array(
		'as' => 'password.reset',
		'uses' => 'Vedette\controllers\PasswordController@reset'
		));
	Route::post('password/reset/{token}', array(
		'before' => 'csrf',
		'as' => 'password.update',
		'uses' => 'Vedette\controllers\PasswordController@update'
		));
});

Route::group(array('before' => 'auth'), function()
{
	Route::resource('user', 'Vedette\controllers\UserController', array(
		'except' => array('index', 'create', 'store')
		));
});

Route::get('login', array(
	'as' =>'login',
	'uses' => 'Vedette\controllers\SessionsController@create'
	));
Route::get('logout', array(
	'as' =>'logout',
	'uses' => 'Vedette\controllers\SessionsController@destroy'
	));
Route::resource('sessions', 'Vedette\controllers\SessionsController', array(
	'before' => 'csrf',
	'only' => array('create', 'store', 'destroy')
	));

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
	Route::get('/', array(
		'as' => 'admin.index',
		'uses' => 'Vedette\controllers\AdminController@index'
		));
	Route::resource('roles', 'Vedette\controllers\RolesController',
		array('except' => array('show')
		));
	Route::resource('users', 'Vedette\controllers\UsersController',
		array('except' => array('show')
		));
});
