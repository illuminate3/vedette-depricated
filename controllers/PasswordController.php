<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\PasswordRemind;
use Vedette\helpers\forms\form\PasswordReset;
use Vedette\helpers\forms\exceptions\FormValidationException;

use View;

class PasswordController extends \BaseController {

	/**
	 * Passwird remind form validator
	 *
	 * @var Project\Forms\Form\PasswordRemind
	 */
	protected $remindForm;

	/**
	 * Password reset form validator
	 *
	 * @var Project\Forms\Form\PasswordReset
	 */
	protected $resetForm;

	/**
	 * Construct the password controller with a password remind and password reset form validator
	 *
	 * @param Project\Forms\Form\PasswordRemind $remindForm
	 * @param Project\Forms\Form\PasswordReset $resetForm
	 */
	public function __construct(PasswordRemind $remindForm, PasswordReset $resetForm)
	{
		$this->remindForm = $remindForm;
		$this->resetForm = $resetForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function remind()
	{
		return View::make('password.remind');
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
			$message->subject('Password Reminder');
		});

		if ($response != Password::REMINDER_SENT)
		{
			return Redirect::back()
				->withMessage(Bootstrap::danger('An error occured sending the password reminder.', true))
				->withInput();
		}

		return Redirect::back()->withMessage(Bootstrap::success('Password reminder sent successfully.', true));
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
		return View::make('password.reset')->with('token', $token);
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
			return Redirect::back()->withMessage(Bootstrap::danger('An error occured resetting your password', true))
				->withInput();
		}

		return Redirect::to('login')->withMessage(Bootstrap::success('Your password has been reset', true));
	}
}
