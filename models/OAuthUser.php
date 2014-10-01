<?php namespace Vedette\models;
/*
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vedette\helpers\presenters\PresentableTrait;

use Vedette\models\Role as Role;
*/
use Eloquent;
use DB;
use Hash;
use Config;
use DateTime;
use Auth;
use Redirect;
use Bootstrap;
use route;

//class OAuthUser extends Eloquent implements UserInterface, RemindableInterface {
class OAuthUser extends \User {

/**
 * This class will handle all of the Sentry user functionalities.
 * The user oauths table which is used to maintain the data for O Auth
 * is also handled from this class.
 * @author Amitav Roy
 *
 */

//	use PresentableTrait;

	/**
	* This function will check if the user exist in the Sentry user table.
	* Will return true or false accordingly.
	*
	* @param string $email
	* @return boolean
	*/
	public function checkIfUserExist ($email)
	{

//dd($email);

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
	private function userDataFromOAuth($result)
	{
/*
		$userData = array(
//			'oauth_id' => $result['id'],
			'oauth_email' => $result['email'],
			'oauth_name' => $result['name'],
			'oauth_given_name' => $result['given_name'],
			'oauth_family_name' => $result['family_name'],
			'oauth_link' => $result['link'],
			'oauth_picture' => $result['picture'],
			'oauth_gender' => $result['gender'],
			'oauth_updated' => time()
		);
*/
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
| This function will get the prepared OAuth data and update the oauths table.
| This function is called every time a user is logging in to udate his profile info.
|--------------------------------------------------------------------------
| @param unknown $result
| @return return the udpated row.
*/
	public function updateUserProfile ($result)
	{


		// get user data from OAuth
		$userData = $this->userDataFromOAuth($result);
//dd($userData);

		// updating the table
//		DB::table('oauths')->where('oauth_email', $result['email'])->update($userData);
		DB::table('profiles')->where('email', $result['email'])->update($userData);

/*
// Update an entry
DB::table('oauths')
	->where('oauth_email', '=', $result['email'])
	->update($userData);
*/

		// get the row which was updated.
//		$row = DB::table('oauths')->where('oauth_email', $result['email'])->first();
		$row = DB::table('profiles')->where('email', $result['email'])->first();
//dd($row);
		return $row;
	}

/*
|--------------------------------------------------------------------------
| Create User Profile
|--------------------------------------------------------------------------
| This function will create a new user using Sentry
| Then it will insert a new record in the oauths and users_groups tables
| users_groups role will default to '1' which should be the users group
|--------------------------------------------------------------------------
| @param unknown $result
| @return unknown
*/
public function createUserProfile($result)
{
//dd('loaded');

//dd($createUser);
/*
// do not store oauth data ... insert to profiles and users
	// get the user data from OAuth
	$userData = $this->userDataFromOAuth($result);
	// set user id
	$userData['user_id'] = $createUser['id'];
	// insert the data
	$id = DB::table('oauths')->insertGetId($userData);
*/

//dd($result['email']);
	// fetch the row which was inserted
//$userData = new StdClass();

	// create the user
//	$createUser = $this->createUser($result);
	// create the sentry user
	$createUser = $this->createUser($result);

	$createProfile = $this->userDataFromOAuth($result);
//dd($createProfile);


	$userData = DB::table('users')->where('email', $result['email'])->first();

	// Pre Populate the Profile using Oauth information
	DB::table('profiles')
		->insert(array(
			'user_id' => $userData->{'id'},
			'first_name' => $createProfile['first_name'],
			'last_name' => $createProfile['last_name'],
			'email' => $createProfile['email'],
			'picture' => $createProfile['picture']
		));


//dd($userData);

	// Assign the user a role
	DB::table('role_user')
		->insert(array(
			'role_id' => Config::get('vedette.vedette_db.default_role_id'),
			'user_id' => $userData->{'id'}
		));

//	return $row;
}

/**
* This private function is creating the Sentry user only.
* @param unknown $result
* @return unknown
*/
private function createUser($result)
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
			'updated_at'		=> new DateTime,
		));

return $createUser;
}

/*
|--------------------------------------------------------------------------
| Login User
|--------------------------------------------------------------------------
| This function will login a user based on the user id provided and set the session data accordingly.
|--------------------------------------------------------------------------
| @param unknown $userId
*/
	public function loginOauthUser ($userId)
	{
//dd($userId);

$loginUser = $this->getUserCredentials($userId);

//dd($loginUser->{'email'});

		$attempt = Auth::attempt(
			array(
				'email' => $loginUser->{'email'},
				'password' => $loginUser->{'email'}
//			isset($input['remember_me']) ?: false
			));

//dd($attempt);

		if ($attempt && Auth::User()->hasRoleWithName('Admin')) {

//dd('1');
			return Redirect::route('admin.index');
//				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
dd('2');

		} elseif ($attempt) {
dd('3');

//dd(Auth::User()->id);
			return Redirect::route('user.show', Auth::User()->id)
				->withMessage(Bootstrap::success( trans('lingos::auth.success.login'), true));
dd('4');

		} else {
//dd('5');

//		return Redirect::back()->withMessage(Bootstrap::danger('Invalid credentials.', true))->withInput();
		return Redirect::route('login');
//			->withMessage(Bootstrap::danger( trans('lingos::auth.error.authorize'), true))->withInput();
dd('6');
		}
dd('7');

/*
		$thisUser = Sentry::findUserById($userId);
		Sentry::login($thisUser, true);
		Session::put('checkAuth', 'true');
		Session::put('authUser', $this->getFullUserDetails($userId));
*/
	}

	/**
	* This function is accumulating the sentry user and also adding the oauths table the details of a user.
	* This can be always called instead of Snetry user to get all user details.
	* @param unknown $userId
	* @return unknown
	*/

	public function getUserCredentials($userId)
	{
/*
	$thisUser = User::findUserById($userId);
	$thisUser['oauths'] = DB::table('oauths')->where('user_id',
		$userId)->first();
*/
		$thisUser = DB::table('users')->where('id', $userId)->first();

	return $thisUser;
	}


}
