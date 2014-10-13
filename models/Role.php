<?php namespace Vedette\models;

use Vedette\helpers\presenters\PresentableTrait;
use Eloquent;

class Role extends Eloquent {

	use PresentableTrait;

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

	public $errors;


// DEFINE Fillable --------------------------------------------------
	protected $fillable = array(
		'name', 'active', 'description', 'level'
	);

// DEFINE Rules --------------------------------------------------
	public static $rules = [
		'name' => 'required|unique:roles,name'
	];

	public static $rulesUpdate = [
		'name' => 'required'
	];


// DEFINE Relationships --------------------------------------------------
	public function user()
	{
		return $this->hasMany('Vedette\models\User');
	}


// Functions --------------------------------------------------


}
