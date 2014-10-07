<?php namespace Vedette\models;

//use Vedette\models\Role as Role;
//use Vedette\models\User as User;
use Eloquent;

class Profile extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profiles';


// DEFINE Relationships --------------------------------------------------

	/**
	 * The user relationship.
	 *
	 * @var User
	 */
	public function user()
	{
		return $this->belongsToMany('Vedette\models\User');
	}

}
