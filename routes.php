<?php

/*
Route::get('/', function()
{
new helpers\forms\form\Login;
)};
*/

//Route::get('/', 'Vedette\controllers\AdminController@index');

Route::get('/', array(
	'as' => 'home',
	'uses' => 'Vedette\controllers\IndexController@index'
	));

/*
Route::group(array('before' => 'guest'), function()
{
	Route::get('/', array(
		'as' => 'home',
		'uses' => 'Vedette\controllers\IndexController@index'
		));
});
*/

Route::get(Config::get('vedette.vedette_routes.user_home'), array(
	'as' => 'vedette.user',
	'uses' => 'Vedette\Controllers\IndexController@index')
);
Route::get(Config::get('vedette.vedette_routes.admin_home'), array(
	'as' => 'vedette.admin',
	'uses' => 'Vedette\Controllers\AdminController@index')
);



Route::get('/404', array(
	'as' => 'notfound',
	'uses' => 'Vedette\controllers\AdminController@notfound'
	));

Route::group(array('before' => 'guest'), function()
{
	Route::get('/', array(
		'as' =>'login',
		'uses' => 'Vedette\controllers\SessionsController@create'
		));

	Route::get('register', array(
		'as' =>'register',
		'uses' => 'Vedette\controllers\AuthController@create'
		));
	Route::resource('auth', 'Vedette\controllers\AuthController',
		array('only' => array('create', 'store')
		));

	Route::get('password/forgot', array(
		'as' => 'forgot',
		'uses' => 'Vedette\controllers\PasswordController@forgot'
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

/*
Route::group(array('before' => 'auth'), function()
{
	Route::resource('auth', 'Vedette\controllers\AuthController', array(
		'except' => array('index', 'create', 'store')
		));
});
*/

Route::get('login', array(
	'as' =>'login',
	'uses' => 'Vedette\controllers\SessionsController@create'
	));

//Route::get('o-auth/login', 'Vedette\controllers\SessionsController@handleLoginPage');

Route::get('o-auth/login', array(
	'as' =>'o-auth/login',
	'uses' => 'Vedette\controllers\SessionsController@handleLoginPage'
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
	Route::get('admin', array(
		'as' => 'admin.index',
		'uses' => 'Vedette\controllers\AdminController@index'
		));
	Route::resource('roles', 'Vedette\controllers\RolesController',
		array('except' => array('show')
		));
	Route::resource('users', 'Vedette\controllers\UsersController',
		array(
			'before' => 'csrf'
//			'except' => array('show')
		));
});
