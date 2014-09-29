<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class PasswordReset extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'token' => 'required',
		'email' => 'required|email',
		'password' => 'required|min:6|confirmed',
		'password_confirmation' => 'required'
	);

}
