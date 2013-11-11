<?php

# Logout
Route::get('logout', array('as' => 'logout', 'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogout'));

Route::filter('auth', function()
{
  if (Auth::guest())
	{
		// Save the attempted URL
		Session::put('loginRedirect', URL::current());

		// Redirect to login
		return Redirect::to('login');
	}
		// Save the attempted URL
		Session::put('loginRedirect', URL::current());

		// Redirect to login
		return Redirect::to('login');
});

Route::post('signin', function()
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
		if ( Session::has('loginRedirect') )
		{
			$url = Session::get('loginRedirect');
			Session::forget('loginRedirect');
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
# User Management
Route::group(array('prefix' => 'auth'), function()
{
//	Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
//	Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
//	Route::post('create', 'Controllers\Admin\UsersController@postCreate');
	Route::get('users/{userId}/edit', array(
		'as' => 'update/user',
		'uses' => 'Illuminate3\Vedette\Controllers\UsersController@edit')
	);
	Route::post('users/{userId}/edit', 'Illuminate3\Vedette\Controllers\UsersController@update');
//	Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
//	Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
});

*/


//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

/*
|--------------------------------------------------------------------------
| Vedette Routes
|--------------------------------------------------------------------------
*/

Route::get('admin', array(
    'as'     => 'admin',
    'uses'   => 'Illuminate3\Vedette\Controllers\VedetteController@index',
    'before' => 'auth.vedette:admin.view'
));

Route::group(array('prefix' => 'auth', 'before' => 'auth.vedette'), function()
{
    Route::resource('users', 'Illuminate3\Vedette\Controllers\UsersController');
    Route::resource('groups', 'Illuminate3\Vedette\Controllers\GroupsController',array('except' => array('show')));
    Route::resource('permissions', 'Illuminate3\Vedette\Controllers\PermissionsController',array('except' => array('show')));
});
Route::controller('users', 'Illuminate3\Vedette\Controllers\UsersController');

/*
|--------------------------------------------------------------------------
| Vedette Extra Users Routes
|--------------------------------------------------------------------------
*/

Route::put('auth/users/{users}/activate', array(
    'as'     => 'auth.users.activate',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@putStatus',
    'before' => 'auth.vedette:users.update'
));

Route::put('auth/users/{users}/deactivate', array(
    'as'     => 'auth.users.deactivate',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@putStatus',
    'before' => 'auth.vedette:users.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Users Permissions Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/users/{users}/permissions', array(
    'as'     => 'auth.users.permissions',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@index',
    'before' => 'auth.vedette:users.update'
));

Route::put('auth/users/{users}/permissions', array(
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@update',
    'before' => 'auth.vedette:users.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Users Throttling Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/users/{user}/throttling', array(
    'as'     => 'auth.users.throttling',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersThrottlingController@getStatus',
    'before' => 'auth.vedette:users.view'
));

Route::put('auth/users/{user}/throttling/{action}', array(
    'as'     => 'auth.users.throttling.update',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersThrottlingController@putStatus',
    'before' => 'auth.vedette:users.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Groups Permissions Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/groups/{groups}/permissions', array(
    'as'     => 'auth.groups.permissions',
    'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@index',
    'before' => 'auth.vedette:groups.update'
));

Route::put('auth/groups/{groups}/permissions', array(
    'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@update',
    'before' => 'auth.vedette:groups.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Login/Logout/Register Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/login', array(
    'as'   => 'auth.login',
//    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogin'
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getSignin'
));

//Route::post('auth/login','Illuminate3\Vedette\Controllers\VedetteController@postLogin');
Route::post('auth/login','Illuminate3\Vedette\Controllers\VedetteController@postSignin');

Route::get('auth/logout', array(
    'as'   => 'auth.logout',
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogout'
));

Route::get('auth/register', array(
    'as'   => 'auth.register',
//    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getRegister'
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getSignup'
));

//Route::post('admin/register','Illuminate3\Vedette\Controllers\VedetteController@postRegister');
Route::post('auth/register','Illuminate3\Vedette\Controllers\VedetteController@postSignup');

/*
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
    if (! Sentry::check())
    {
        Session::put('url.intended', URL::full());
        return Redirect::route('auth.login');
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
    if ( ! Sentry::hasAccess($userRule) and $userRule !== 'auth.view' )
    {
        return Redirect::route('auth.home')->with('error', Lang::get('vedette::permissions.access_denied'));
    }
    // no access to the request page and request page is the root admin page
    else if( ! Sentry::hasAccess($userRule) and $userRule === 'auth.view' )
    {
        //can't see the admin home page go back to home site page
        return Redirect::to('/')->with('error', Lang::get('vedette::permissions.access_denied'));
    }

});
