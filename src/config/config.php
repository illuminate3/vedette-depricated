<?php

return array(

/*
|--------------------------------------------------------------------------
| General configs used for naming conventions
|--------------------------------------------------------------------------
*/
'vedette_config' => array(
	'site_name'				=> 'Vedette',
	'title'					=> 'My Admin Panel',
	'site_team'				=> 'Vedette Team',
	'description'			=> 'Laravel 4 Admin Panel'
),


/*
|--------------------------------------------------------------------------
| Package settings
|--------------------------------------------------------------------------
*/
'vedette_settings' => array(
	'prefix_auth'			=> 'auth',
	'home_route'			=> '/',
),


/*
|--------------------------------------------------------------------------
| General views and standard package views
|--------------------------------------------------------------------------
*/
'vedette_views' => array(

	// The layoiut to use : change to what matches your application
	'layout'				=> 'vedette::layouts',

	// Dashboard area : change to something more appropriate or build out what is provided
	'dashboard'				=> 'vedette::auth.index',

	// Following views won't probably be needed to be over ridden but just in case

	// Auth views
	'auth'					=> 'vedette::auth.index',
	'login'					=> 'vedette::auth.login',
	'register'				=> 'vedette::auth.register',
	'forgot'				=> 'vedette::auth.forgot-password',
	'forgot_confirm'		=> 'vedette::auth.forgot-password-confirm',

	// Users views
	'users_index'			=> 'vedette::users.index',
	'users_show'			=> 'vedette::users.show',
	'users_edit'			=> 'vedette::users.edit',
	'users_create'			=> 'vedette::users.create',
	'users_permission'		=> 'vedette::users.permission',

	//Groups Views
	'groups_index'			=> 'vedette::groups.index',
	'groups_create'			=> 'vedette::groups.create',
	'groups_edit'			=> 'vedette::groups.edit',
	'groups_permission'		=> 'vedette::groups.permission',

	//Permissions Views
	'permissions_index'		=> 'vedette::permissions.index',
	'permissions_edit'		=> 'vedette::permissions.edit',
	'permissions_create'	=> 'vedette::permissions.create',

	//Throttling Views
	'throttle_status'		=> 'vedette::throttle.index',

	//Email Views
	'forgot_password'		=> 'vedette::emails.forgot-password',
	'register_activate'		=> 'vedette::emails.register-activate',
	'reminder'				=> 'vedette::emails.reminder',
	'email_layout'			=> 'vedette::emails.layouts.default',

),


/*
|--------------------------------------------------------------------------
| Validation rules location
|--------------------------------------------------------------------------
| Need to add a section here to allow overriding of the rules used in the package
|--------------------------------------------------------------------------
*/

'validation' => array(
	'user'					=> 'Illuminate3\Vedette\Services\Validators\Users\Validator',
	'permission'			=> 'Illuminate3\Vedette\Services\Validators\Permissions\Validator',
),

);
