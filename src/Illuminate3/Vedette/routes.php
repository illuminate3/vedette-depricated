<?php

Route::get(Config::get('vedette::vedette_settings.home_route'), array(
	'as' => 'vedette.home',
	'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@index')
);


/*
|--------------------------------------------------------------------------
| @author Steve Montambeault
| @link   http://stevemo.ca
|--------------------------------------------------------------------------
| Login/Logout/Register Routes
|--------------------------------------------------------------------------
*/

Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth')),
	function()
{

// Shortcut Routes
	Route::get('admin', array(
		'as'     => 'vedette.admin',
		'uses'   => 'Illuminate3\Vedette\Controllers\VedetteController@index',
		'before' => 'auth.vedette:admin.view'
	));
	Route::get('users', array(
		'as'     => 'vedette.users',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@index',
		'before' => 'auth.vedette:users.view'
	));
	Route::get('groups', array(
		'as'     => 'vedette.groups',
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsController@index',
		'before' => 'auth.vedette:groups.view'
	));
	Route::get('permissions', array(
		'as'     => 'vedette.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\PermissionsController@index',
		'before' => 'auth.vedette:groups.view'
	));

// Login/Sign In
	Route::get('login', array(
		'as'   => 'vedette/login',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogin'
	));
	Route::post('login', array(
		'as'   => 'vedette.login',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@postLogin'
	));

// Logout/Sign Out
	Route::get('logout', array(
		'as'   => 'vedette.logout',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogout'
	));

// Register/Sign Up
	Route::get('register', array(
		'as'   => 'vedette.register',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getRegister'
	));

	Route::post('register', array(
		'as'   => 'vedette.register',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@postRegister'
	));

// Forgot Password
	Route::get('forgot-password', array(
		'as' => 'vedette.forgot-password',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getForgotPassword'
		));
	Route::post('forgot-password', array(
		'as' => 'vedette.forgot-password',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@postForgotPassword'
		));

// Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array(
		'as' => 'vedette.forgot-password-confirm',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getForgotPasswordConfirm'
		));
	Route::post('forgot-password/{passwordResetCode}', array(
		'as' => 'vedette.forgot-password/{passwordResetCode}',
		'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@postForgotPasswordConfirm'
		));

});


/*
|--------------------------------------------------------------------------
| @author Steve Montambeault
| @link   http://stevemo.ca
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth'),
	'before' => 'auth.vedette'),
	function()
{
	Route::resource('users', 'Illuminate3\Vedette\Controllers\UsersController');
	Route::resource('groups', 'Illuminate3\Vedette\Controllers\GroupsController',array('except' => array('show')));
	Route::resource('permissions', 'Illuminate3\Vedette\Controllers\PermissionsController',array('except' => array('show')));
});


/*
|--------------------------------------------------------------------------
| @author Steve Montambeault
| @link   http://stevemo.ca
|--------------------------------------------------------------------------
| Users Permissions Routes
|--------------------------------------------------------------------------
*/

Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth')),
	function()
{

// Users

	Route::get('users/{users}/permissions', array(
		'as'     => 'auth.users.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@index',
		'before' => 'auth.vedette:users.update'
	));

	Route::put('users/{users}/permissions', array(
//		'as'     => 'auth.users.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@update',
		'before' => 'auth.vedette:users.update'
	));

// Groups

	Route::get('groups/{groups}/permissions', array(
		'as'     => 'auth.groups.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@index',
		'before' => 'auth.vedette:groups.update'
	));

	Route::put('groups/{groups}/permissions', array(
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@update',
		'before' => 'auth.vedette:groups.update'
	));


});

/*
|--------------------------------------------------------------------------
| @author Steve Montambeault
| @link   http://stevemo.ca
|--------------------------------------------------------------------------
| Admin auth filter
|--------------------------------------------------------------------------
| You need to give your routes a name before using this filter.
| I assume you are using resource. so the route for the UsersController index method
| will be auth.users.index then the filter will look for permission on users.view
| You can provide your own rule by passing a argument to the filter
|
*/

Route::filter('auth.vedette', function($route, $request, $userRule = null)
{

	if ( !Sentry::check() )
	{
		Session::put('url.intended', URL::full());
		return Redirect::route('vedette.login');
	}

// no special route name passed, use the current name route
	if ( is_null($userRule) )
	{
		list($prefix, $module, $rule) = explode('.', Route::currentRouteName());
		switch ($rule)
		{
			case 'index':
			case 'show':
				$userRule = $module.'.view';
				break;
			case 'create':
			case 'store':
				$userRule = $module.'.create';
				break;
			case 'edit':
			case 'update':
				$userRule = $module.'.update';
				break;
			case 'destroy':
				$userRule = $module.'.delete';
				break;
			default:
				$userRule = Route::currentRouteName();
				break;
		}
	}

// no access to the request page and request page not the root admin page
	if ( !Sentry::hasAccess($userRule) and $userRule !== 'auth.view' )
	{
		return Redirect::route('vedette.login')->with('error', trans('lingos::sentry.permission_error.insufficient'));
	}
// no access to the request page and request page is the root admin page
	else if( !Sentry::hasAccess($userRule) and $userRule === 'auth.view' )
	{
//can't see the admin home page go back to home site page
		return Redirect::to('vedette.login')->with('error', trans('lingos::sentry.permission_error.insufficient'));
	}

});
