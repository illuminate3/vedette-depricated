<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class RoleCreate extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'name' => 'required|unique:roles'
	);

}
