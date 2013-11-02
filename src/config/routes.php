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
/*
Route::get('/', function()
{
	return View::make('hello');
});
*/

Route::filter('auth', function()
{
  if (Auth::guest())
	{
		// Save the attempted URL
		Session::put('pre_login_url', URL::current());

		// Redirect to login
		return Redirect::to('login');
	}
});

Route::post('login', function()
{
  // Get the POST data
	$data = array(
		'username'      => Input::get('username'),
		'password'      => Input::get('password')
	);

	// Attempt Authentication
	if ( Auth::attempt($data) )
	{
		// If user attempted to access specific URL before logging in
		if ( Session::has('pre_login_url') )
		{
			$url = Session::get('pre_login_url');
			Session::forget('pre_login_url');
			return Redirect::to($url);
		}
		else
			return Redirect::to('admin');
	}
	else
	{
		return Redirect::to('login')->with('login_errors', true);
	}
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/
Route::group(array('prefix' => 'vedette'), function()
{
/*
	# Blog Management
	Route::group(array('prefix' => 'blogs'), function()
	{
		Route::get('/', array('as' => 'blogs', 'uses' => 'Controllers\Admin\BlogsController@getIndex'));
		Route::get('create', array('as' => 'create/blog', 'uses' => 'Controllers\Admin\BlogsController@getCreate'));
		Route::post('create', 'Controllers\Admin\BlogsController@postCreate');
		Route::get('{blogId}/edit', array('as' => 'update/blog', 'uses' => 'Controllers\Admin\BlogsController@getEdit'));
		Route::post('{blogId}/edit', 'Controllers\Admin\BlogsController@postEdit');
		Route::get('{blogId}/delete', array('as' => 'delete/blog', 'uses' => 'Controllers\Admin\BlogsController@getDelete'));
		Route::get('{blogId}/restore', array('as' => 'restore/blog', 'uses' => 'Controllers\Admin\BlogsController@getRestore'));
	});
*/
	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
		Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
		Route::post('create', 'Controllers\Admin\UsersController@postCreate');
		Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
		Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
		Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
		Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
		Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
		Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
		Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
		Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
		Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
	});

});

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function()
{

# Login
//Route::get('signin', array('as' => 'signin', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogin'));
//Route::post('signin', 'Illuminate3\Vedette\Controllers\VedetteController@postLogin');
Route::get('signin', array('as' => 'signin', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getSignin'));
Route::post('signin', 'Illuminate3\Vedette\Controllers\VedetteController@postSignin');

# Register
//Route::get('signup', array('as' => 'signup', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getRegister'));
//Route::post('signup', 'Illuminate3\Vedette\Controllers\VedetteController@postRegister');
Route::get('signup', array('as' => 'signup', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getSignup'));
Route::post('signup', 'Illuminate3\Vedette\Controllers\VedetteController@postSignup');

# Forgot Password
Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getForgotPassword'));
Route::post('forgot-password', 'Illuminate3\Vedette\Controllers\VedetteController@postForgotPassword');

# Forgot Password Confirmation
Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getForgotPasswordConfirm'));
Route::post('forgot-password/{passwordResetCode}', 'Illuminate3\Vedette\Controllers\VedetteController@postForgotPasswordConfirm');

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account1'), function()
{

	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex'));
	Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex'));
	Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex'));
	Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');

});
/*
// account routes
Route::get('account/profile', array('as' => 'account.profile', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\AccountController@getProfile'));
Route::delete('account/profile', array('as' => 'account.profile.delete', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\AccountController@deleteProfile'));
Route::patch('account/details', array('as' => 'account.details.patch', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\AccountController@patchDetails'));
Route::patch('account/password', array('as' => 'account.password.patch', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\AccountController@patchPassword'));


// login routes
Route::get('account/login', array('as' => 'account.login', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\LoginController@getLogin'));
Route::post('account/login', array('as' => 'account.login.post', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\LoginController@postLogin'));
Route::get('account/logout', array('as' => 'account.logout', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\LoginController@getLogout'));


// reset route
Route::get('account/reset', array('as' => 'account.reset', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\ResetController@getReset'));
Route::post('account/reset', array('as' => 'account.reset.post', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\ResetController@postReset'));
Route::get('account/password/{id}/{code}', array('as' => 'account.password', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\ResetController@getPassword'));


// registration routes
Route::get('account/register', array('as' => 'account.register', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\RegistrationController@getRegister'));
Route::post('account/register', array('as' => 'account.register.post', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\RegistrationController@postRegister'));
Route::get('account/activate/{id}/{code}', array('as' => 'account.activate', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\RegistrationController@getActivate'));

// user routes
Route::resource('users', 'GrahamCampbell\BootstrapCMS\Controllers\UserController');
Route::post('users/{users}/suspend', array('as' => 'users.suspend', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\UserController@suspend'));
Route::post('users/{users}/reset', array('as' => 'users.reset', 'uses' => 'GrahamCampbell\BootstrapCMS\Controllers\UserController@reset'));

