<?php namespace Illuminate3\Vedette\Controllers;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use View;
use Config;
use Input;
use Sentry;
use Redirect;
use Lang;
use Event;
use Validator;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
use URL;
use Mail;

class VedetteController extends BaseController {


    /**
     * Show the dashboard
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function index()
    {
        return View::make(Config::get('vedette::views.dashboard'));
    }

    /**
     * Show the login form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function getLogin()
    {

		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('/');
		}

        $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        return View::make(Config::get('vedette::views.login'), compact('login_attribute'));
    }

    /**
     * Display the registration form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function getRegister()
    {
        $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        return View::make(Config::get('vedette::views.register'), compact('login_attribute'));
    }

    /**
     * Logs out the current user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        if (Sentry::check())
        {
            $user = Sentry::getUser();
            Sentry::logout();
            Event::fire('users.logout', array($user));
            return Redirect::route('admin.login')->with('success', Lang::get('vedette::users.logout'));
        }
        return Redirect::route('admin.login');
    }

    /**
     * Authenticate the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return Response
     */
    public function postLogin()
    {
        try
        {
            $remember = Input::get('remember_me', false);
            $userdata = array(
                Config::get('cartalyst/sentry::users.login_attribute') => Input::get('login_attribute'),
                'password' => Input::get('password')
            );

            $user = Sentry::authenticate($userdata, $remember);
            Event::fire('users.login', array($user));
            return Redirect::intended('admin')->with('success', Lang::get('vedette::users.login_success'));
        }
        catch (LoginRequiredException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (WrongPasswordException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserNotActivatedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserSuspendedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserBannedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
    }

    /**
     * Register user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function postRegister()
    {
        try
        {
            $validation = $this->getValidationService('user');

            if( $validation->passes() )
            {
                //TODO : Do something with the activation code later on
                //TODO : Setting to activate or not, email also
                $user = Sentry::register($validation->getData(), true);
                Event::fire('users.register', array($user));

                return Redirect::route('admin.login')->with('success', Lang::get('vedette::users.register_success'));
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
	 * taken from brunogaspar/laravel4-starter-kit
	 * Forgot password page.
	 *
	 * @return View
	 */
	public function getForgotPassword()
	{
		// Show the page
		return View::make('vedette::auth.forgot-password');
	}

	/**
	 * taken from brunogaspar/laravel4-starter-kit
	 * Forgot password form processing page.
	 *
	 * @return Redirect
	 */
	public function postForgotPassword()
	{
		// Declare the rules for the validator
		$rules = array(
			'email' => 'required|email',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('forgot-password')->withInput()->withErrors($validator);
		}

		try
		{
			// Get the user password recovery code
			$user = Sentry::getUserProvider()->findByLogin(Input::get('email'));

			// Data to be used on the email view
			$data = array(
				'user'              => $user,
				'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
			);

			// Send the activation code through email
			Mail::send('vedette::emails.forgot-password', $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name);
				$m->subject( Lang::get('lingos::auth.account_password_recovery') );
			});
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Even though the email was not found, we will pretend
			// we have sent the password reset code through email,
			// this is a security measure against hackers.
		}

		//  Redirect to the forgot password
		return Redirect::route('forgot-password')->with('success', Lang::get('auth/message.forgot-password.success'));
	}

	/**
	 * taken from brunogaspar/laravel4-starter-kit
	 * Forgot Password Confirmation page.
	 *
	 * @param  string  $passwordResetCode
	 * @return View
	 */
	public function getForgotPasswordConfirm($passwordResetCode = null)
	{
		try
		{
			// Find the user using the password reset code
			$user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
		}
		catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
		}

		// Show the page
		return View::make('vedette::auth.forgot-password-confirm');
	}

	/**
	 * taken from brunogaspar/laravel4-starter-kit
	 * Forgot Password Confirmation form processing page.
	 *
	 * @param  string  $passwordResetCode
	 * @return Redirect
	 */
	public function postForgotPasswordConfirm($passwordResetCode = null)
	{
		// Declare the rules for the form validation
		$rules = array(
			'password'         => 'required',
			'password_confirm' => 'required|same:password'
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
		}

		try
		{
			// Find the user using the password reset code
			$user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);

			// Attempt to reset the user password
			if ($user->attemptResetPassword($passwordResetCode, Input::get('password')))
			{
				// Password successfully reseted
				return Redirect::route('signin')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
			}
			else
			{
				// Ooops.. something went wrong
				return Redirect::route('signin')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
			}
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
		}
	}

}
