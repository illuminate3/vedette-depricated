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
	public function checkIfUserExist ($email)
	{
		$user = DB::table('users')->where('email', '=', $email)->first();
		if ($user)
			return $user;
		else
			return false;
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
	// get user data from OAuth
		$userData = $this->userDataFromOAuth($result);
	// updating profiles
		DB::table('profiles')->where('email', $result['email'])->update($userData);

		Session::put('userPicture', $userData['picture']);

	// get updated row
		$row = DB::table('profiles')->where('email', $result['email'])->first();

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
	//			'password'			=> Hash::make(md5(microtime().Config::get('app.key'))),
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
