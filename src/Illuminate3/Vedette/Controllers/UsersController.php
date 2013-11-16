<?php namespace Illuminate3\Vedette\Controllers;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use Cartalyst\Sentry\Users\UserAlreadyActivatedException;
use View;
use Config;
use Redirect;
use Lang;
use Input;
use Event;
use Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;


class UsersController extends BaseController {

    /**
     * Show all the users
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function index()
    {
        $users = Sentry::getUserProvider()->createModel()->with('groups')->get();

		foreach ($users as $user) {
			$throttles = Sentry::getThrottleProvider()->findByUserId($user->id);
		}

        return View::make(Config::get('vedette::vedette_views.users_index'), compact('users', 'throttles'));
    }

    /**
     * Show a user profile
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($id);
			$throttles = Sentry::getThrottleProvider()->findByUserId($id);
            return View::make(Config::get('vedette::vedette_views.users_show'),compact('user', 'throttles'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('auth.users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display add user form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function create()
    {
        return View::make(Config::get('vedette::vedette_views.users_create'))->with('success', trans('lingos::sentry.user_success.create'));
    }

    /**
     * Display the user edit form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try
        {
            $user   = Sentry::getUserProvider()->findById($id);
            $groups = Sentry::getGroupProvider()->findAll();

            //get only the group id the user belong to
            $userGroupsId = array_pluck($user->getGroups()->toArray(), 'id');

			$throttles = Sentry::getThrottleProvider()->findByUserId($id);

            return View::make(Config::get('vedette::vedette_views.users_edit'),compact('user','groups','userGroupsId', 'throttles'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('auth.users.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Create a new user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function store()
    {
        try
        {
            $validation = $this->getValidationService('user');

            if( $validation->passes() )
            {
                //create the user
                $user = Sentry::register($validation->getData(), true);
                Event::fire('users.create', array($user));
                return Redirect::route('auth.users.index')->with('success', trans('lingos::sentry.user_success.create'));
            }

            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        catch (LoginRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
        catch (UserExistsException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try
        {
            $credentials = Input::except('groups', 'banned', 'suspended');
            $credentials['id'] = $id;
            $validation = $this->getValidationService('user', $credentials);

            if( $validation->passes() )
            {
                $user = Sentry::getUserProvider()->findById($id);
                $user->fill($validation->getData());


if (Input::has('activated'))
{
	if ($user->isActivated())
	{
	//
	} else {
		$user = Sentry::getUserProvider()->findById($id);
		$activationCode = $user->getActivationCode();
		$user->attemptActivation($activationCode);
	}
} else {
	$user->activated = 0;
	$user->activated_at = null;
}
// update throttle
$throttle = Sentry::getThrottleProvider()->findByUserId($id);
if (Input::has('suspended'))
{
	// Suspend the user
	$throttle->suspend();
} else {
	// Suspend the user
	$throttle->unsuspend();
}
if (Input::has('banned'))
{
	// Ban the user
	$throttle->ban();
} else {
	// Ban the user
	$throttle->unBan();
}

                $user->save();

                //update groups
                $user->groups()->detach();
                $user->groups()->sync(Input::get('groups',array()));
                Event::fire('users.update', array($user));

                return Redirect::route('auth.users.index')->with('success', trans('lingos::sentry.user_success.update'));
            }

            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        catch ( UserExistsException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
        catch ( LoginRequiredException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }

	catch ( UserAlreadyActivatedException $e)
	{
            return Redirect::back()->with('error', $e->getMessage());
	}

    }

    /**
     * Delete a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $currentUser = Sentry::getUser();

        if ($currentUser->id === (int) $id)
        {
            return Redirect::back()->with('error', trans('lingos::sentry.user_error.denied') );
        }

        try
        {
            $user = Sentry::getUserProvider()->findById($id);
            $eventData = $user;
            $user->delete();
            Event::fire('users.delete', array($eventData));
            return Redirect::route('auth.users.index')->with('success',trans('lingos::sentry.user_success.delete'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('auth.users.index')->with('error',$e->getMessage());
        }
    }

    /**
     * activate or deactivate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putStatus($id)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($id);

            if ($user->isActivated())
            {
                $user->activated = 0;
                $user->activated_at = null;
                $user->save();
                return Redirect::route('auth.users.index')->with('success',trans('lingos::sentry.user_success.deactivate'));
            }
            else
            {
                $code = $user->getActivationCode();

                if ($user->attemptActivation($code))
                {
                    // User activation passed
                    return Redirect::route('auth.users.index')->with('success',trans('lingos::sentry.user_success.activate'));
                }
                else
                {
                    // User activation failed
                    return Redirect::route('auth.users.index')->with('error',trans('lingos::sentry.user_error.activate'));
                }
            }
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('auth.users.index')->with('error',$e->getMessage());
        }
        catch (UserAlreadyActivatedException $e)
        {
            return Redirect::route('auth.users.index')->with('error',$e->getMessage());
        }
    }


	public function postDelete($id)
	{
		try
		{
		    // Find the user using the user id
		    $user = Sentry::getUserProvider()->findById($id);

		    // Delete the user
		    if ($user->delete())
		    {
		        // User was successfully deleted
return Redirect::route('auth.users.index')->with('success',trans('lingos::sentry.user_success.delete'));
		    }
		    else
		    {
		        // There was a problem deleting the user
return Redirect::route('auth.users.index')->with('danger',trans('lingos::sentry.user_error.delete'));
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
return Redirect::route('auth.users.index')->with('danger',trans('lingos::sentry.user_error.not_found'));
		}
	}

}
