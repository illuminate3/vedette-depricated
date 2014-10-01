<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class Login extends FormValidator {
//dd('loaded');
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'email' => 'required|email',
		'password' => 'required'
	);

}
