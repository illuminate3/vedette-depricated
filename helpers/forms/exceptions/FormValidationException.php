<?php namespace Vedette\helpers\forms\exceptions;

use Exception;
use Illuminate\Support\MessageBag;

class FormValidationException extends Exception {

	/**
	 * The stored form validation errors
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	/**
	 * Construct a form validation exception
	 *
	 * @param string     $message
	 * @param MessageBag $errors
	 *
	 * @return self
	 */
	public function __construct($message, MessageBag $errors)
	{
		$this->errors = $errors;
		parent::__construct($message);
	}

	/**
	 * Get form validation errors
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
		return $this->errors;
	}

}
