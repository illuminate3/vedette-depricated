<?php namespace Vedette\models;

use Eloquent, DB, Hash, Config, Auth, Redirect;
use route;
use Session;
use DateTime;
use Bootstrap;

//class OAuthUser extends \User implements UserInterface, RemindableInterface {
class OAuthUser extends \User {

	/*
	|--------------------------------------------------------------------------
	| check if user exists
	|--------------------------------------------------------------------------
	| @param string $email
	| @return boolean
	*/
	public function checkUserExist ($email)
	{
		$user = DB::table('users')
			->where('email', '=', $email)
//			->where('password', '=', $email, 'AND')
			->first();
//dd($user);

		if ( $user != NULL ) {

/*
		if ( $user->{'password'} != NULL ) {
//		if ( $user != NULL ) {
			return $user;
		} elseif ( $user->{'password'} == NULL ) {
*/

			if ( $this->checkUserRoleExist($user->{'id'}) == False) {
				$this->createUserRole($user->{'id'});
			}

			if ( $user->{'password'} == NULL ) {
				$this->createUserPassword($user->{'email'});
			}

			$user = DB::table('users')
				->where('email', '=', $email)
				->first();

			if ( $user->{'password'} != NULL ) {
				return $user;
			} else {
				dd('error');
			}
		}
	}

	public function checkUserRoleExist($user_id)
	{
		$role_user = DB::table('role_user')
			->where('user_id', '=', $user_id)
			->first();
//dd($role_user);

		if ($role_user == NULL) {
			return False;
		} else {
			return True;
		}
	}

	public function createUserRole($user_id)
	{
		$role_user = DB::table('role_user')
			->insert(array(
				'role_id' => Config::get('vedette.vedette_db.default_role_id'),
				'user_id' => $user_id
			));
//dd($role_user);

		if ($role_user == NULL) {
			return False;
		} else {
			return True;
		}
	}


public function isConfirmed($credentials, $identity_columns = array('username', 'email'))
{
	$user = static::$app['confide.repository']->getUserByIdentity($credentials, $identity_columns);

	if (! is_null($user) and $user->confirmed) {
		return true;
	} else {
		return false;
	}
}

/**
 * Enable throttling.
 *
 * @return void
 */
public function enable()
{
	$this->enabled = true;
}

/**
 * Disable throttling.
 *
 * @return void
 */
public function disable()
{
	$this->enabled = false;
}

/**
 * Check if throttling is enabled.
 *
 * @return bool
 */
public function isEnabled()
{
	return $this->enabled;
}

/**
 * Check if the user is activated.
 *
 * @return bool
 */
public function isActivated()
{
	return (bool) $this->activated;
}


	/*
	|--------------------------------------------------------------------------
	| User Data From Oauth
	|--------------------------------------------------------------------------
	| @param unknown $result
	| @return multitype:unknown number
	*/
	private function userDataFromOAuth ($result)
	{
	//			'oauth_name' => $result['name'],
	//			'oauth_id' => $result['id'],
	//			'oauth_link' => $result['link'],
	//			'oauth_gender' => $result['gender'],

		$userData = array(
			'email'			=> $result['email'],
			'first_name'	=> $result['given_name'],
			'last_name'		=> $result['family_name'],
			'picture'		=> $result['picture'],
//			'updated_at'	=> new DateTime
//			'last_login'	=> new DateTime
		);

		return $userData;
	}

	/*
	|--------------------------------------------------------------------------
	| Update User Profile
	|--------------------------------------------------------------------------
	| @param unknown $result
	| @return return the udpated row.
	*/
	public function updateUserProfile ($result)
	{
//dd($result);
	// get user data from OAuth
		$userData = $this->userDataFromOAuth($result);
//dd($userData['email']);
	// updating profiles
		DB::table('profiles')->where('email', $userData['email'])->update($userData);

		Session::put('userPicture', $userData['picture']);

	// get updated row
		$row = DB::table('profiles')->where('email', $userData['email'])->first();

		return $row;
	}

	/*
	|--------------------------------------------------------------------------
	| Create User Profile
	|--------------------------------------------------------------------------
	| @param unknown $result
	| @return unknown
	*/
	public function createUserProfile ($result)
	{
//dd($result);
	// create user
		$createUser = $this->createUser($result);
	// get user data from OAuth
		$userData = $this->userDataFromOAuth($result);
	// get newly created user
		$newUser = DB::table('users')->where('email', $result['email'])->first();

	// Pre Populate the Profile using Oauth information
		DB::table('profiles')
			->insert(array(
				'user_id'		=> $newUser->{'id'},
				'first_name'	=> $userData['first_name'],
				'last_name'		=> $userData['last_name'],
				'email'			=> $userData['email'],
				'picture'		=> $userData['picture']
			));

		Session::put('userPicture', $userData['picture']);

	// Assign the user to a group
		DB::table('role_user')
			->insert(array(
				'role_id' => Config::get('vedette.vedette_db.default_role_id'),
				'user_id' => $newUser->{'id'}
	//			'user_id' => $userData['user_id']
			));

	// fetch the row which was inserted
		$row = DB::table('profiles')->where('email', $result['email'])->first();

		return $row;
	}

	/*
	|--------------------------------------------------------------------------
	| Create User
	|--------------------------------------------------------------------------
	| @param unknown $result
	| @return unknown
	*/
	private function createUser ($result)
	{
	// Create the user
		$createUser = DB::table('users')
			->insert(array(
				'email'				=> $result['email'],
//				'password'			=> Hash::make(md5(microtime().Config::get('app.key'))),
				'password'			=> Hash::make($result['email']),
				'activation_code'	=> md5(microtime().Config::get('app.key')),
				'activated'			=> Config::get('vedette.vedette_db.activated'),
				'verified'			=> Config::get('vedette.vedette_db.verified'),
				'created_at'		=> new DateTime,
				'updated_at'		=> new DateTime
//				'last_login'		=> new DateTime
		));

	return $createUser;
	}


	/*
	|--------------------------------------------------------------------------
	| Create User Password
	|--------------------------------------------------------------------------
	| @param unknown $result
	| @return unknown
	*/
	private function createUserPassword($userEmail)
	{
//dd('loaded');
	// Create the user Password
		DB::table('users')
			->where('email', '=', $userEmail)
			->update(array(
					'password'			=> Hash::make($userEmail)
				));

/*
		$createUserPassword = DB::table('users')
			->insert(array(
				'password'			=> Hash::make($userEmail)
		));
	return $createUserPassword;
*/
	}

	/*
	|--------------------------------------------------------------------------
	| Get User Credentials
	|--------------------------------------------------------------------------
	| @param unknown $userId
	| @return unknown
	*/
	public function getUserCredentials($userId)
	{
		$thisUser = DB::table('users')->where('id', $userId)->first();

		return $thisUser;
	}

	public function touchLastLogin($email)
	{
		$id = DB::table('users')
			->where('email', '=', $email)
			->pluck('id');

		$user = User::find($id);
		$user->last_login = new DateTime;

		$user->update();
//		return $users;
	}

}
