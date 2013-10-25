<?php

return array(

    'site_config' => array(
        'site_name'   => 'Vedette',
        'title'       => 'My Admin Panel',
        'description' => 'Laravel 4 Admin Panel'
    ),

    //menu 2 type are available single or dropdown and it must be a route
    'menu' => array(
        'Dashboard' => array('type' => 'single', 'route' => 'admin.home'),
        'Users'     => array('type' => 'dropdown', 'links' => array(
            'Manage Users' => array('route' => 'admin.users.index'),
            'Groups'       => array('route' => 'admin.groups.index'),
            'Permissions'  => array('route' => 'admin.permissions.index')
        )),
    ),

    'views' => array(

//        'layout' => 'vedette::layouts',
        'layout' => 'frontend/layouts/default',

        'dashboard' => 'vedette::dashboard.index',
        'login'     => 'vedette::dashboard.login',
        'register'  => 'vedette::dashboard.register',

        // Users views
        'users_index'      => 'vedette::users.index',
        'users_show'       => 'vedette::users.show',
        'users_edit'       => 'vedette::users.edit',
        'users_create'     => 'vedette::users.create',
        'users_permission' => 'vedette::users.permission',

        //Groups Views
        'groups_index'      => 'vedette::groups.index',
        'groups_create'     => 'vedette::groups.create',
        'groups_edit'       => 'vedette::groups.edit',
        'groups_permission' => 'vedette::groups.permission',

        //Permissions Views
        'permissions_index'  => 'vedette::permissions.index',
        'permissions_edit'   => 'vedette::permissions.edit',
        'permissions_create' => 'vedette::permissions.create',

        //Throttling Views
        'throttle_status' => 'vedette::throttle.index',
    ),

    'validation' => array(
        'user'       => 'Illuminate3\Vedette\Services\Validators\Users\Validator',
        'permission' => 'Illuminate3\Vedette\Services\Validators\Permissions\Validator',
    ),
);
