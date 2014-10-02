<?php namespace Vedette\models;

use Eloquent;
use DB;
use Hash;
use Config;
use DateTime;
use Auth;
use Redirect;
use Bootstrap;
use route;
use Session;

//class OAuthUser extends Eloquent implements UserInterface, RemindableInterface {
class OAuthUser extends \User {

	/**
	* This function will check if the user exist in the Sentry user table.
	* Will return true or false accordingly.
	*
	* @param string $email
	* @return boolean
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
| User Date From Oauth
|--------------------------------------------------------------------------
| This funtion will take the OAuth data that we got from Oauth authentication
| and return the prepared array ready for save or udpate to the users_detail table.
|--------------------------------------------------------------------------
| @param unknown $result
| @return multitype:unknown number
*/
	private function userDataFromOAuth ($result)
	{
		$userData = array(
//			'oauth_id' => $result['id'],
			'email' => $result['email'],
//			'oauth_name' => $result['name'],
			'first_name' => $result['given_name'],
			'last_name' => $result['family_name'],
//			'oauth_link' => $result['link'],
			'picture' => $result['picture'],
//			'oauth_gender' => $result['gender'],
			'updated_at' => new DateTime
		);

		return $userData;
	}

/*
|--------------------------------------------------------------------------
| Update User Profile
|--------------------------------------------------------------------------
| This function will get the prepared OAuth data and update the details table.
| This function is called every time a user is logging in to udate his profile info.
|--------------------------------------------------------------------------
| @param unknown $result
| @return return the udpated row.
*/
	public function updateUserProfile ($result)
	{
		// get user data from OAuth
		$userData = $this->userDataFromOAuth($result);
		// updating the table
		DB::table('profiles')->where('email', $result['email'])->update($userData);
/*
// Update an entry
DB::table('details')
	->where('oauth_email', '=', $result['email'])
	->update($userData);
*/

		// get the row which was updated.
		$row = DB::table('profiles')->where('email', $result['email'])->first();

		return $row;
	}

/*
|--------------------------------------------------------------------------
| Create User Profile
|--------------------------------------------------------------------------
| This function will create a new user using Sentry
| Then it will insert a new record in the details and users_groups tables
| users_groups role will default to '1' which should be the users group
|--------------------------------------------------------------------------
| @param unknown $result
| @return unknown
*/
public function createUserProfile ($result)
{
	// create the sentry user
	$sentryUser = $this->createUser($result);
	// get the user data from OAuth
	$userData = $this->userDataFromOAuth($result);

	// set user id
//	$userData['user_id'] = $sentryUser['id'];
//dd($sentryUser);
	$sentryUser = DB::table('users')->where('email', $result['email'])->first();

	// Pre Populate the Profile using Oauth information
	DB::table('profiles')
		->insert(array(
			'user_id' => $sentryUser->{'id'},
			'first_name' => $userData['first_name'],
			'last_name' => $userData['last_name'],
			'email' => $userData['email'],
			'picture' => $userData['picture']
		));

	// insert the data
//	$id = DB::table('profiles')->insertGetId($userData);

	// Assign the user to a group
	DB::table('role_user')
		->insert(array(
			'role_id' => Config::get('vedette.vedette_db.default_role_id'),
			'user_id' => $sentryUser->{'id'}
//			'user_id' => $userData['user_id']
		));

	// fetch the row which was inserted
	$row = DB::table('profiles')->where('email', $result['email'])->first();

	return $row;
}

	/**
	* This private function is creating the Sentry user only.
	* @param unknown $result
	* @return unknown
	*/
	private function createUser ($result)
	{
	// Create the user
/*
	$sentryUser = Sentry::createUser(
		array(
			'email' => $result['email'],
			'password' => time() . rand(999, 9999),
			'activated' => true,
			'first_name' => $result['given_name'],
			'last_name' => $result['family_name']
		));
*/
	$createUser = DB::table('users')
		->insert(array(
			'email'				=> $result['email'],
//			'password'			=> Hash::make(md5(microtime().Config::get('app.key'))),
			'password'			=> Hash::make($result['email']),
			'activation_code'	=> md5(microtime().Config::get('app.key')),
			'activated'			=> Config::get('vedette.vedette_db.activated'),
			'verified'			=> Config::get('vedette.vedette_db.verified'),
			'created_at'		=> new DateTime,
			'updated_at'		=> new DateTime,
		));

	return $createUser;
	}

	/**
	* This function is accumulating the sentry user and also adding the details table details of a user.
	* This can be always called instead of Snetry user to get all user details.
	* @param unknown $userId
	* @return unknown
	*/

	public function getUserCredentials($userId)
	{
		$thisUser = DB::table('users')->where('id', $userId)->first();
//dd($thisUser);
	return $thisUser;
	}

}
