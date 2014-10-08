<?php namespace Vedette\controllers;

use View;
use Input;
use Redirect;
use Bootstrap;
use Config;
use Password;

class PasswordController extends \BaseController {

/*
	public function __construct(PasswordRemind $remindForm, PasswordReset $resetForm)
	{
		$this->remindForm = $remindForm;
		$this->resetForm = $resetForm;
	}
*/

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function forgot()
	{
		return View::make(
			Config::get('vedette.vedette_views.forgot')
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function request()
	{
		$input = Input::only('email');
		$this->remindForm->validate($input);

		$response = Password::remind($input, function($message)
		{
			$message->subject( trans('lingos::email.subject_reminder') );
		});

		if ($response != Password::REMINDER_SENT)
		{
			return Redirect::back()
				->withMessage(Bootstrap::danger( trans('lingos::auth.error.password_send'), true, true))
				->withInput();
		}

		return Redirect::back()->withMessage(Bootstrap::success( trans('lingos::auth.success.password_send'), true, true));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param string $token
	 *
	 * @return Response
	 */
	public function reset($token)
	{
		return View::make(
			Config::get('vedette.vedette_views.reset')
		)->with('token', $token);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update()
	{
		$input = Input::only('email', 'password', 'password_confirmation', 'token');
		$this->resetForm->validate($input);

		$response = Password::reset($input, function($user, $password)
		{
			$user->password = Hash::make($password);
			$user->save();
		});

		if ($response !=  Password::PASSWORD_RESET)
		{
			return Redirect::back()->withMessage(Bootstrap::danger( trans('lingos::auth.error.password_reset'), true, true))
				->withInput();
		}

		return Redirect::to('login')->withMessage(Bootstrap::success( trans('lingos::auth.success.password_reset'), true, true));
	}
}
