<?php namespace Vedette\helpers\forms\contracts;

use Illuminate\Validation\Factory as Validator;

interface FormValidationInterface {

	/**
	 * Construct form validator with a validator
	 *
	 * @param Validator $validator
	 *
	 * @return self
	 */
	public function __construct(Validator $validator);

	/**
	 * Validate the form data
	 *
	 * @param array $formData
	 *
	 * @return boolean
	 */
	public function validate(array $formData);

}
