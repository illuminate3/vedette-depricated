<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class UserCreate extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'email' => 'required|email|unique:users',
		'password' => 'required|confirmed|min:6',
		'password_confirmation' => 'required'
	);

}
