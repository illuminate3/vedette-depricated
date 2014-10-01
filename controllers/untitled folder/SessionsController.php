<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\Login as Login;
use Vedette\helpers\forms\exceptions\FormValidationException;
use Illuminate\Auth\UserInterface;

//use Vedette\models\Session as Session;
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
	 * Login form validator
	 *
	 * @var Project\Forms\Form\Login
	 */
	protected $loginForm;
	protected $OAuthUser;

	/**
	 * Construct the session controller with a login form validator
	 *
	 * @param Project\Forms\Form\Login $loginForm
	 */
/*
	public function __construct(Login $loginForm, OAuthUser $OAuthUser)
	{
		$this->loginForm = $loginForm;
		$this->OAuthUser = $OAuthUser;
	}
*/
	public function __construct(Login $loginForm, OAuthUser $OAuthUser)
	{
		$this->loginForm = $loginForm;
		$this->OAuthUser = $OAuthUser;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
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
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		Session::flush();

//$data = Session::all();
//dd($data);

		return Redirect::home()->withMessage(Bootstrap::success( trans('lingos::auth.success.logout'), true));
	}


public function handleLoginPage()
{
//		Auth::logout();
//		Session::flush();


If ( Session::get('checkAuth') != True ) {
//dd('checkAuth');
	// get data from input
	$code = Input::get('code');
//dd($code);
	// get google service
	$googleService = OAuth::consumer('Google');
//dd($googleService);
	// if code is provided get user data and sign in
	if (! empty($code)) {
		// This was a callback request from google, get the token
		$token = $googleService->requestAccessToken($code);

		// Send a request with it
		$result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
//dd($result);

//		$userOAuth = new OAuthUser();

		if ( Config::get('vedette.vedette_settings.hosted_domain') == True ) {
			if ( (isset($result['hd']) ) && ($result['hd'] == Config::get('vedette.vedette_settings.hosted_domain')) ) {
				$this->ProcessOauth($result);
			} else {
				return Redirect::to('login')
					->withMessage(Bootstrap::danger( trans('lingos::auth.error.activate'), true));
			}
		} else {
				$this->ProcessOauth($result);
		}

	} else {

		// get googleService authorization
		$url = $googleService->getAuthorizationUri();

		// return to facebook login url
		return Redirect::to((string) $url)
			->withMessage(Bootstrap::danger( trans('lingos::auth.error.activate'), true));

	}
} else {

//$data = Session::all();
//dd($data);

		if ( Auth::check() ) {
//		dd('Authcheck');
					return Redirect::route('home')
						->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
		} else {
					return Redirect::route('home')
					->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true));
		}
}


} // OAuth

public function ProcessOauth($result)
{

//dd($result['id']);
//	$userOAuth = new OAuthUser();
//dd($userOAuth

$loginUser = $this->OAuthUser->checkIfUserExist($result['email']);
//dd($loginUser->{'id'});

//	if ( $this->OAuthUser->checkIfUserExist($result['email']) ) {
if ( $loginUser != Null ) {

//dd($userOAuth);
		// update the profile of the user
		$currentUser = $this->OAuthUser->updateUserProfile($result);
//dd($currentUser);
		// login the user using entry authentication
//		$this->loginUser($currentUser->user_id);
//		$this->loginUser($currentUser->user_id);
//		$this->loginUser($loginUser->{'id'});
		$this->loginUser($result);

//		return Redirect::to('/')
//			->withMessage(Bootstrap::danger( trans('lingos::auth.success.login'), true));
			return Redirect::route('home')
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));

	} else {

//		$createUser = $userOAuth->createUser($result);
		// create profile of the user in sentry and add user details
		// from OAuth
		$currentUser = $userOAuth->createUserProfile($result);

		// login the user using entry authentication
		$this->loginOauthUser($currentUser->user_id);

dd('9');
		return Redirect::to('/')
			->withMessage(Bootstrap::danger( trans('lingos::auth.success.register'), true));

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
	public function loginUser ($result)
	{
//$data = Session::all();
//dd($data);
//dd($userId);

//		$thisUser = Sentry::findUserById($userId);
//		Sentry::login($thisUser, true);
//$loginUser = $this->OAuthUser->getUserCredentials($userId);
//dd($loginUser);
//		Session::put('checkAuth', True);
//		Session::put('userAuth', $loginUser);


//$loginUser = $this->OAuthUser->getUserCredentials($result);

//dd($loginUser->{'email'});
//dd($result['email']);
		$attempt = Auth::attempt(
			array(
				'email' => $result['email'],
				'password' => $result['email']
//			isset($input['remember_me']) ?: false
			));

//dd($attempt);

		if ($attempt && Auth::User()->hasRoleWithName('Admin')) {

dd('1');
			return Redirect::route('admin.index');
//				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
dd('2');

		} elseif ($attempt) {
//dd('3');

//dd(Auth::User()->id);
			return Redirect::route('home', Auth::User()->id);
//				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
dd('4');

		} else {
dd('5');

//		return Redirect::back()->withMessage(Bootstrap::danger('Invalid credentials.', true))->withInput();
		return Redirect::route('login');
//			->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true))->withInput();
dd('6');
		}
dd('7');


	}

	public function loginOauthUser ($userId)
	{
//dd($userId);

$loginUser = $this->OAuthUser->getUserCredentials($userId);

//dd($loginUser->{'email'});

		$attempt = Auth::attempt(
			array(
				'email' => $loginUser->{'email'},
				'password' => $loginUser->{'email'}
//			isset($input['remember_me']) ?: false
			));
		if ($attempt && Auth::User()->hasRoleWithName('Admin')) {

dd('attempt');
			return Redirect::route('home')
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
		} elseif ($attempt) {

dd('bad attempt');
return Redirect::to('/');
dd('2');
			return Redirect::route('home', Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));

		} else {
dd('fail');
		return Redirect::route('login')
			->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true))->withInput();
		}
	}


}
