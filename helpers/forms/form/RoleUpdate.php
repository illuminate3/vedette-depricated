<?php namespace Vedette\helpers\forms\form;

use Vedette\helpers\forms\FormValidator;

class RoleUpdate extends FormValidator {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	protected $rules = array(
		'name' => 'required'
	);

}
