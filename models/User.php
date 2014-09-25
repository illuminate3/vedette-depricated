<?php namespace Vedette\models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vedette\helpers\presenters\PresentableTrait;

use Vedette\models\Role as Role;
use Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * The attributes allowed to be mass assigned.
	 *
	 * @var array
	 */
	protected $fillable = array('email', 'password', 'remember_token');

	/**
	 * The model presenter.
	 *
	 * @var string
	 */
	protected $presenter = 'Project\Presenters\Presenter\User';

	/**
	 * The role relationship.
	 *
	 * @return Role
	 */
	public function roles()
	{
		return $this->belongsToMany('Vedette\models\Role');
	}

	/**
	 * Setup the Carbon dates.
	 *
	 * @return array
	 */
	public function getDates()
	{
		return array('created_at', 'updated_at');
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Has a user got a certain role.
	 *
	 * @param integer $id
	 *
	 * @return boolean
	 */
	public function hasRole($id)
	{
		foreach ($this->roles as $role)
		{
			if ($role->id == $id)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Has a user got a certain role by name.
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasRoleWithName($name)
	{
		$searchRole = Role::where('name', '=', $name)->first();

		return $this->hasRole($searchRole->id);
	}

}
