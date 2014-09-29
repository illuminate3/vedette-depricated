<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class UserUpdate extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
//		'name' => 'required',
		'email' => 'required|email',
		'password' => 'min:6|confirmed',
		'password_confirmation' => 'required_with:password'
	);

}
