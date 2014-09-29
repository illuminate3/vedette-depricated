<?php namespace Vedette\helpers\forms;

use Vedette\helpers\forms\contracts\FormValidationInterface;
use Vedette\helpers\forms\exceptions\FormValidationException;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Validation\Validator as ValidatorInstance;

abstract class FormValidator implements FormValidationInterface {

	/**
	 * The validator
	 *
	 * @var Validator
	 */
	protected $validator;

	/**
	 * The validator instance
	 *
	 * @var ValidatorInstance
	 */
	protected $validation;

	/**
	 * Construct form validator with a validator
	 *
	 * @param Validator $validator
	 *
	 * @return self
	 */
	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Validate the form data
	 *
	 * @param array $formData
	 *
	 * @return mixed
	 *
	 * @throws FormValidationException
	 */
	public function validate(array $formData)
	{
		$this->validation = $this->validator->make($formData, $this->getValidationRules());

		if ($this->validation->fails())
		{
			new FormValidationException('Validation failed', $this->getValidationErrors());
		}

		return true;
	}

	/**
	 * Get the validation rules
	 *
	 * @return array
	 */
	protected function getValidationRules()
	{
		return $this->rules;
	}

	/**
	 * Set the validation rules
	 *
	 * @param array $rlues
	 *
	 * @return void
	 */
	protected function setValidationRules($rlues)
	{
		$this->rules = $rlues;
	}

	/**
	 * Get the validation errors
	 *
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function getValidationErrors()
	{
		return $this->validation->errors();
	}

}
