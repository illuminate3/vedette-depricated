<?php namespace Vedette\models;

use Vedette\helpers\presenters\PresentableTrait;
use Watson\Validating\ValidatingTrait;

//use Vedette\models\User as User;
use Eloquent;
use Validator;

class Role extends Eloquent {

	use PresentableTrait;
	use ValidatingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * The model presenter.
	 *
	 * @var string
	 */
	protected $presenter = 'Vedette\helpers\presenters\presenter\Role';

	/**
	 * The attributes allowed to be mass assigned.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'name', 'active'
	);


	public static $rules = [
		'name' => 'required|unique:roles,name'
	];

public $errors;

	protected $rulesets = [
		'creating' => [
			'name' => 'required|unique:roles,name'
		],

		'updating' => [
			'name' => 'required'
		],

		'deleting' => [
			'user_id'     => 'required|exists:users,id'
		],

		'saving' => [
			'title'       => 'required',
			'description' => 'required'
		]
	];


	protected $validationMessages = [
		'name.unique' => "Another Role is using that name already."
	];

// DEFINE Relationships --------------------------------------------------

	/**
	 * The user relationship.
	 *
	 * @var User
	 */
	public function user()
	{
		return $this->hasMany('Vedette\models\User');
	}

public function isValid()
{
$validation = Validator::make($this->attributes, static::$rules);

if ( $validation->passes() ) {
return true;
}

$this->errors = $validation->errors();

return false;
}


}
