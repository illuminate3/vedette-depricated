<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class Register extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'email' => 'required|email|unique:users',
		'password' => 'required|min:6',
		'password_confirmation' => 'required'
	);

}
