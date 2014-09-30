<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\Login as Login;
use Vedette\helpers\forms\exceptions\FormValidationException;
use Illuminate\Auth\UserInterface;

use Vedette\models\User as User;
use View;
use Input;
use Auth;
use Redirect;
use Bootstrap;
use Config;

class SessionsController extends \BaseController {

	/**
	 * Login form validator
	 *
	 * @var Project\Forms\Form\Login
	 */
	protected $loginForm;

	/**
	 * Construct the session controller with a login form validator
	 *
	 * @param Project\Forms\Form\Login $loginForm
	 */
	public function __construct(Login $loginForm)
	{
		$this->loginForm = $loginForm;
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

		return Redirect::home()->withMessage(Bootstrap::success( trans('lingos::auth.success.logout'), true));
	}

}
