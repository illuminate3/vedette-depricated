<?php namespace Vedette\controllers;

use Illuminate\Auth\UserInterface;

use Artdarek\OAuth\Facade\OAuth as OAuth;
use Vedette\models\OAuthUser as OAuthUser;
use Vedette\models\User as User;
use View, Input, Auth, Redirect, Config, Session, Validator;
use Bootstrap;

class SessionsController extends \BaseController {

	protected $OAuthUser;

	/**
	 * Constructor
	 */
	public function __construct(OAuthUser $OAuthUser, User $user)
	{
		$this->OAuthUser = $OAuthUser;
		$this->User = $user;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
		return View::make( Config::get('vedette.vedette_views.login') );
	}

	/**
	 * Store
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

//		$validation = Validator::make($input, Role::$rules);
//		$validation = Validator::make($input);

//		if ($validation->passes())
//		{

//		$input = Input::only('email', 'password', 'remember_me');
//		$this->loginForm->validate($input);


		$attempt = Auth::attempt(
			array('email' => $input['email'], 'password' => $input['password']),
			isset($input['remember_me']) ?: false
		);

		$picture =  $this->User->getUserPicture(Auth::User()->id);
		Session::put('userPicture', $picture->picture);
//dd($picture);

		if ($attempt && Auth::User()->hasRoleWithName('Admin')) {
			$this->OAuthUser->touchLastLogin($input['email']);
			return Redirect::route('vedette.admin')
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} elseif ($attempt) {
			$this->OAuthUser->touchLastLogin($input['email']);
			return Redirect::route('vedette.user', Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} else {
			return Redirect::route('login')->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true, true))->withInput();
		}
/*
} else {
			return Redirect::route('login')->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true))->withInput();
}
*/
	}

	/**
	 * Destroy
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
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

			// get token code from google
			$token = $googleService->requestAccessToken($code);

			// Send request
			$result = json_decode( $googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true );

			if ( Config::get('vedette.vedette_settings.hosted_domain') == True ) {
				if ( (isset($result['hd']) ) && ($result['hd'] == Config::get('vedette.vedette_settings.hosted_domain')) ) {
					$this->ProcessOauth($result);
					$this->OAuthUser->touchLastLogin($result['email']);

					if ( Auth::User()->hasRoleWithName('Admin') ) {
						return Redirect::route( Config::get('vedette.vedette_routes.admin_home') )
							->withMessage( Bootstrap::success( trans('lingos::auth.success.login'), true, true) );
					} else  {
						return Redirect::route( Config::get('vedette.vedette_routes.user_home') )
							->withMessage( Bootstrap::success( trans('lingos::auth.success.login'), true, true) );
					}

				} else {
					return Redirect::to('login')
						->withMessage(Bootstrap::danger( trans('lingos::auth.error.activate'), true, true));
				}
			} else {
				$this->ProcessOauth($result);
				$this->OAuthUser->touchLastLogin($input['email']);

				if ( Auth::User()->hasRoleWithName('Admin') ) {
					return Redirect::route( Config::get('vedette.vedette_routes.admin_home') )
						->withMessage( Bootstrap::success( trans('lingos::auth.success.login'), true, true) );
				} else  {
					return Redirect::route( Config::get('vedette.vedette_routes.user_home') )
						->withMessage( Bootstrap::success( trans('lingos::auth.success.login'), true, true) );
				}
			}

		} else {

			// get googleService authorization
			$url = $googleService->getAuthorizationUri();
			// return to google login url
			return Redirect::to((string) $url);

		}
	}

	public function ProcessOauth($result)
	{
		$userOAuth = new OAuthUser();

		if ($userOAuth->checkIfUserExist($result['email'])) {
			// update user profile
			$currentUser = $this->OAuthUser->updateUserProfile($result);
			// login user
			$this->loginUser($currentUser->user_id);
		} else {
			// create profile based on OAuth
			$currentUser = $this->OAuthUser->createUserProfile($result);
			// login user
			$this->loginUser($currentUser->user_id);
		}

	}

	/*
	|--------------------------------------------------------------------------
	| Login User
	|--------------------------------------------------------------------------
	| This function will login a user based on the user id provided and set the session data accordingly.
	|--------------------------------------------------------------------------
	| @param unknown $userId
	*/
	public function loginUser ($userId)
	{
		$loginUser = $this->OAuthUser->getUserCredentials($userId);

		$attempt = Auth::attempt(
			array(
				'email' => $loginUser->{'email'},
				'password' => $loginUser->{'email'}
	//			isset($input['remember_me']) ?: false
			));

		if ( $attempt && Auth::User()->hasRoleWithName('Admin') ) {
			return Redirect::route('vedette.admin')
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} elseif ( $attempt ) {
			return Redirect::route('vedette.user', Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} else {
			return Redirect::route('login')
				->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true, true))->withInput();
		}

		Session::put('userPicture', $userData['picture']);

//		Session::put('checkAuth', True);
//		Session::put('userAuth', $loginUser);
	}

}
