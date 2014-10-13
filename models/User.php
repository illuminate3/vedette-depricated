<?php namespace Vedette\models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vedette\helpers\presenters\PresentableTrait;

use Vedette\models\Role as Role;
use Eloquent;
use DB;

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
	 * The model presenter.
	 *
	 * @var string
	 */
	protected $presenter = 'Vedette\helpers\presenters\presenter\User';

	public $errors;


// DEFINE Rules --------------------------------------------------
	public static $rules = [
		'email' => 'required|email|unique:users',
		'password' => 'required|confirmed|min:6',
		'password_confirmation' => 'required_with:password'
	];

	public static $rulesUpdate = [
		'email' => 'required|email',
		'password' => 'min:6|confirmed',
		'password_confirmation' => 'required_with:password'
	];

// DEFINE Fillable --------------------------------------------------
	protected $fillable = array(
		'email', 'password', 'remember_token'
	);


// DEFINE Relationships --------------------------------------------------

	public function roles()
	{
		return $this->belongsToMany('Vedette\models\Role');
	}

	public function profile()
	{
		return $this->hasOne('Vedette\models\Profile');
	}


// Functions --------------------------------------------------

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
		$searchRole = Role::where('name', '=', $name)->remember(10)->first();
		return $this->hasRole($searchRole->id);
	}

	public function deleteUserProfile($user_id)
	{
		$profile = DB::table('profiles')
			->where('user_id', '=', $user_id)
			->delete();
	}

	public function countUsers()
	{
		$users = DB::table('users')->remember(10)->count();
		return $users;
	}

	public function getUserPicture($user_id)
	{
		$profile = DB::table('profiles')
			->where('user_id', '=', $user_id)
			->first();

//dd($profile);
		return $profile;
	}

}
