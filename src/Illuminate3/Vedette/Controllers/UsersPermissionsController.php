<?php namespace Illuminate3\Vedette\Controllers;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use View;
use Redirect;
use Input;
use Lang;
use Event;
use Sentry;
use Config;
use Illuminate3\Vedette\Provider\PermissionProvider;
use Cartalyst\Sentry\Users\UserNotFoundException;

class UsersPermissionsController extends BaseController {


    /**
     * @var PermissionProvider
     */
    protected $permissions;

    public function __construct( PermissionProvider $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Display the user permissins
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $userId
     * @return Response
     */
    public function index($userId)
    {
        try
        {
            $user       = Sentry::getUserProvider()->findById($userId);
            $modulePerm = $this->permissions->getMergePermissions($user->getPermissions());

            $roles = array(array('name' => 'generic', 'permissions' => array('view','create','update','delete')));
            $genericPerm = $this->permissions->getMergePermissions($user->getPermissions(), $roles);

            return View::make(Config::get('vedette::vedette_views.users_permission'),compact('user','modulePerm','genericPerm'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('auth.users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update user permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $userId
     * @return Response
     */
    public function update($userId)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($userId);

            $user->permissions = Input::get('rules', array());
            $user->save();

            Event::fire('users.permissions.update', array($user));

            return Redirect::route('auth.users.index')->with('success', trans('lingos::sentry.permission_success.update'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('auth.users.permissions')->with('error', $e->getMessage());
        }

    }

}
