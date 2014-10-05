<?php namespace Vedette\models;

use Eloquent;

use Vedette\models\Role as Role;
use Vedette\models\User as User;

class UserRole extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role_user';

	/**
	 * The attributes allowed to be mass assigned.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'user_id', 'role_id'
	);

	/**
	 * The timestamps attributes.
	 *
	 * @var boolean
	 */
	public $timestamps = false;


// DEFINE Relationships --------------------------------------------------

	/**
	 * The user relationship.
	 *
	 * @var User
	 */
	public function user()
	{
		return $this->hasOne('Vedette\models\User');
	}

	/**
	 * The role relationship.
	 *
	 * @var Role
	 */
	public function role()
	{
		return $this->hasOne('Vedette\models\Role');
	}
}
