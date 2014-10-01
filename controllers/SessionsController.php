<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\Login as LoginForm;
use Vedette\helpers\forms\exceptions\FormValidationException;
use Illuminate\Auth\UserInterface;

use Vedette\models\OAuthUser as OAuthUser;
use View;
use Input;
use Auth;
use Redirect;
use Bootstrap;
use Config;
use Artdarek\OAuth\Facade\OAuth as OAuth;
//use OAuth;
use Session;

class SessionsController extends \BaseController {


	/**
	 * Member Vars
	 */
	protected $OAuthUser;
	protected $loginForm;

	/**
	 * Constructor
	 */
	public function __construct(OAuthUser $OAuthUser, LoginForm $loginForm)
	{
		$this->OAuthUser = $OAuthUser;
		$this->loginForm = $loginForm;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
/*
if ( Config::get('site.auth_type') == 'google' ) {
//	return View::make('oauth.login');
	return Redirect::to('o-auth/login');
} else {
	return View::make('sessions.login');
}
*/
//	Session::flush();
		return View::make(
			Config::get('vedette.vedette_views.login')
		);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

/*
		// Form Processing
		$result = $this->loginForm->save( Input::all() );
		if( $result['success'] )
		{
			Event::fire('user.login', array(
				'userId' => $result['sessionData']['userId'],
				'email' => $result['sessionData']['email']
				));
			// Success!
			return Redirect::to('/');
		} else {
			Session::flash('error', $result['message']);
			return Redirect::to('login')
				->withInput()
				->withErrors( $this->loginForm->errors() );
		}
*/
		$input = Input::only('email', 'password', 'remember_me');
		$this->loginForm->validate($input);

		$attempt = Auth::attempt(
			array('email' => $input['email'], 'password' => $input['password']),
			isset($input['remember_me']) ?: false
		);

//dd($attempt);

		if ($attempt && Auth::User()->hasRoleWithName('Admin')) {
			return Redirect::route('admin.index')
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
		} elseif ($attempt) {

//dd(Auth::User()->id);
			return Redirect::route('user.show', Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
		} else {

//		return Redirect::back()->withMessage(Bootstrap::danger('Invalid credentials.', true))->withInput();
		return Redirect::route('login')->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true))->withInput();
		}


	}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return Response
 */
public function destroy()
{
/*
	$this->session->destroy();
	Event::fire('user.logout');
	return Redirect::to('/');
*/

//	Sentry::logout();
//	$this->session->destroy();
	Auth::logout();
	Session::flush();

	return Redirect::to('/');

}

public function handleLoginPage ()
{
	// get data from input
	$code = Input::get('code');

	// get google service
	$googleService = OAuth::consumer('Google');

	// if code is provided get user data and sign in
	if (! empty($code)) {
		// This was a callback request from google, get the token
		$token = $googleService->requestAccessToken($code);

		// Send a request with it
		$result = json_decode(
		$googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

		$userOAuth = new OAuthUser();

		if ( ( isset($result['hd']) ) && ($result['hd'] == 'bryantschools.org') ) {

			if ($userOAuth->checkIfUserExist($result['email'])) {

				// update the profile of the user
				$currentUser = $userOAuth->updateUserProfile($result);
				// login the user using entry authentication
				$userOAuth->loginUser($currentUser->user_id);

			} else {

				// create profile of the user in sentry and add user details
				// from OAuth
				$currentUser = $userOAuth->createUserProfile($result);
				// login the user using entry authentication
				$userOAuth->loginUser($currentUser->user_id);

			}

//			return Redirect::to('o-auth/dashboard/' . $currentUser->user_id);
			return Redirect::to('/');

		} else {
			return Redirect::to('/');
		}

	} else {

		// get googleService authorization
		$url = $googleService->getAuthorizationUri();
		// return to facebook login url
		return Redirect::to((string) $url);

	}
} // OAuth

}
