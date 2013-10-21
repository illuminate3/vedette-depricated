<?php
/*
|--------------------------------------------------------------------------
| Vedette Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('admin', array(
    'as'     => 'admin.home',
    'uses'   => 'Illuminate3\Vedette\Controllers\VedetteController@index',
    'before' => 'auth.vedette:admin.view'
));

Route::group(array('prefix' => 'admin', 'before' => 'auth.vedette'), function()
{
    Route::resource('users', 'Illuminate3\Vedette\Controllers\UsersController');
    Route::resource('groups', 'Illuminate3\Vedette\Controllers\GroupsController',array('except' => array('show')));
    Route::resource('permissions', 'Illuminate3\Vedette\Controllers\PermissionsController',array('except' => array('show')));
});

/*
|--------------------------------------------------------------------------
| Vedette Extra Users Routes
|--------------------------------------------------------------------------
|
|
*/
Route::put('admin/users/{users}/activate', array(
    'as'     => 'admin.users.activate',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@putStatus',
    'before' => 'auth.vedette:users.update'
));

Route::put('admin/users/{users}/deactivate', array(
    'as'     => 'admin.users.deactivate',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@putStatus',
    'before' => 'auth.vedette:users.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Users Permissions Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('admin/users/{users}/permissions', array(
    'as'     => 'admin.users.permissions',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@index',
    'before' => 'auth.vedette:users.update'
));

Route::put('admin/users/{users}/permissions', array(
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@update',
    'before' => 'auth.vedette:users.update'
));


/*
|--------------------------------------------------------------------------
| Vedette Users Throttling Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('admin/users/{user}/throttling', array(
    'as'     => 'admin.users.throttling',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersThrottlingController@getStatus',
    'before' => 'auth.vedette:users.view'
));

Route::put('admin/users/{user}/throttling/{action}', array(
    'as'     => 'admin.users.throttling.update',
    'uses'   => 'Illuminate3\Vedette\Controllers\UsersThrottlingController@putStatus',
    'before' => 'auth.vedette:users.update'
));

/*
|--------------------------------------------------------------------------
| Vedette Groups Permissions Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('admin/groups/{groups}/permissions', array(
    'as'     => 'admin.groups.permissions',
    'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@index',
    'before' => 'auth.vedette:groups.update'
));

Route::put('admin/groups/{groups}/permissions', array(
    'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@update',
    'before' => 'auth.vedette:groups.update'
));


/*
|--------------------------------------------------------------------------
| Vedette Login/Logout/Register Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('admin/login', array(
    'as'   => 'admin.login',
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogin'
));

Route::post('admin/login','Illuminate3\Vedette\Controllers\VedetteController@postLogin');

Route::get('admin/logout', array(
    'as'   => 'admin.logout',
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getLogout'
));

Route::get('admin/register', array(
    'as'   => 'admin.register',
    'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@getRegister'
));

Route::post('admin/register','Illuminate3\Vedette\Controllers\VedetteController@postRegister');


/*
|--------------------------------------------------------------------------
| Admin auth filter
|--------------------------------------------------------------------------
| You need to give your routes a name before using this filter.
| I assume you are using resource. so the route for the UsersController index method
| will be admin.users.index then the filter will look for permission on users.view
| You can provide your own rule by passing a argument to the filter
|
*/
Route::filter('auth.vedette', function($route, $request, $userRule = null)
{
    if (! Sentry::check())
    {
        Session::put('url.intended', URL::full());
        return Redirect::route('admin.login');
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
    if ( ! Sentry::hasAccess($userRule) and $userRule !== 'admin.view' )
    {
        return Redirect::route('admin.home')->with('error', Lang::get('vedette::permissions.access_denied'));
    }
    // no access to the request page and request page is the root admin page
    else if( ! Sentry::hasAccess($userRule) and $userRule === 'admin.view' )
    {
        //can't see the admin home page go back to home site page
        return Redirect::to('/')->with('error', Lang::get('vedette::permissions.access_denied'));
    }

});
