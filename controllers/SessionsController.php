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
		Session::flush();
		Auth::logout();

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
//dd(Auth::User());
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
//dd($result);
		if ($userOAuth->checkUserExist($result['email'])) {
//dd('true');
			// update user profile
			$currentUser = $this->OAuthUser->updateUserProfile($result);
			// login user
			$this->loginUser($currentUser->user_id);
		} else {
//dd('false');
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
	| @param unknown $userId
	*/
	public function loginUser ($userId)
	{
		$loginUser = $this->OAuthUser->getUserCredentials($userId);
//dd($loginUser->{'email'});
		$attempt = Auth::attempt(
			array(
				'email' => $loginUser->{'email'},
				'password' => $loginUser->{'email'}
	//			isset($input['remember_me']) ?: false
			));
//dd($attempt);
		if ( $attempt && Auth::User()->hasRoleWithName('Admin') ) {
			return Redirect::route( Config::get('vedette.vedette_routes.admin_home') )
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} elseif ( $attempt ) {
			return Redirect::route( Config::get('vedette.vedette_routes.user_home') , Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true, true));
		} else {
			return Redirect::route('login')
				->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true, true))->withInput();
		}

		Session::put('userPicture', $userData['picture']);

//		Session::put('checkAuth', True);
//		Session::put('userAuth', $loginUser);
	}

	/*
	|--------------------------------------------------------------------------
	| Login User
	|--------------------------------------------------------------------------
	| @param unknown $userId
	*/
public function processThrottle()
{

// dont forget to look at UserController for the parts where you can unban the user!!!

// cleanup oauthuser ... it has user stuff in it. Should make a 3rd section jsut for vedetteServices ....

$request = Request::instance();
$request->setTrustedProxies(array('127.0.0.1')); // only trust proxy headers coming from the IP addresses on the array (change this to suit your needs)
$ip = $request->getClientIp();
// OR!!!
// https://github.com/fideloper/TrustedProxy
// http://fideloper.com/laravel-4-trusted-proxies
// this looks like a better solution!


// Check if there was too many login attempts
if ( Confide::isThrottled( $input ) ) {
	$err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
} elseif ( $this->OAuthUser->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
	$err_msg = Lang::get('confide::confide.alerts.not_confirmed');
} else {
	$err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
}

return Redirect::to('user/login')
	->withInput(Input::except('password'))
	->with( 'error', $err_msg );
}
/**
 * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
 *
 * @return bool
 */
public function check()
{
	if (is_null($this->user))
	{
		// Check session first, follow by cookie
		if ( ! $userArray = $this->session->get() and ! $userArray = $this->cookie->get())
		{
			return false;
		}

		// Now check our user is an array with two elements,
		// the username followed by the persist code
		if ( ! is_array($userArray) or count($userArray) !== 2)
		{
			return false;
		}

		list($id, $persistCode) = $userArray;

		// Let's find our user
		try
		{
			$user = $this->getUserProvider()->findById($id);
		}
		catch (UserNotFoundException $e)
		{
			return false;
		}

		// Great! Let's check the session's persist code
		// against the user. If it fails, somebody has tampered
		// with the cookie / session data and we're not allowing
		// a login
		if ( ! $user->checkPersistCode($persistCode))
		{
			return false;
		}

		// Now we'll set the user property on Sentry
		$this->user = $user;
	}

	// Let's check our cached user is indeed activated
	if ( ! $user = $this->getUser() or ! $user->isActivated())
	{
		return false;
	}
	// If throttling is enabled we check it's status
	if( $this->getThrottleProvider()->isEnabled())
	{
		// Check the throttle status
		$throttle = $this->getThrottleProvider()->findByUser( $user );

		if( $throttle->isBanned() or $throttle->isSuspended())
		{
			$this->logout();
			return false;
		}
	}

	return true;
}

} // end SessionController
