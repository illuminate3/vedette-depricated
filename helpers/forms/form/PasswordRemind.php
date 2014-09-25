<?php namespace Vedette\helpers\forms\Form;

use Vedette\helpers\forms\FormValidator;

class PasswordRemind extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'email' => 'required|email'
	);

}
