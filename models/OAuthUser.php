<?php namespace Vedette\models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vedette\helpers\presenters\PresentableTrait;

use Vedette\models\Role as Role;
use Eloquent;

class OAuthUser extends Eloquent implements UserInterface, RemindableInterface {

/**
 * This class will handle all of the Sentry user functionalities.
 * The user details table which is used to maintain the data for O Auth
 * is also handled from this class.
 * @author Amitav Roy
 *
 */

	use PresentableTrait;

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
			'oauth_id' => $result['id'],
			'oauth_email' => $result['email'],
			'oauth_name' => $result['name'],
			'oauth_given_name' => $result['given_name'],
			'oauth_family_name' => $result['family_name'],
			'oauth_link' => $result['link'],
			'oauth_picture' => $result['picture'],
			'oauth_gender' => $result['gender'],
			'oauth_updated' => time()
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
		DB::table('details')->where('oauth_email', $result['email'])->update($userData);
/*
// Update an entry
DB::table('details')
	->where('oauth_email', '=', $result['email'])
	->update($userData);
*/

		// get the row which was updated.
		$row = DB::table('details')->where('oauth_email', $result['email'])->first();

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
	$sentryUser = $this->createSentryUser($result);
	// get the user data from OAuth
	$userData = $this->userDataFromOAuth($result);

	// set user id
	$userData['user_id'] = $sentryUser['id'];
	// insert the data
	$id = DB::table('details')->insertGetId($userData);
	// fetch the row which was inserted
	$row = DB::table('details')->where('oauth_email', $result['email'])->first();
	// Assign the user to a group
	DB::table('users_groups')
		->insert(array(
			'user_id' => $userData['user_id'],
			'group_id' => '1'
		));
	// Pre Populate the Profile using Oauth information
	DB::table('profiles')
		->insert(array(
			'user_id' => $userData['user_id'],
//			'user_id' => $sentryUser['id'],
			'first_name' => $userData['oauth_given_name'],
			'last_name' => $userData['oauth_family_name'],
			'email' => $userData['oauth_email'],
			'picture' => $userData['oauth_picture']
		));

	return $row;
}

  /**
   * This private function is creating the Sentry user only.
   * @param unknown $result
   * @return unknown
   */
  private function createSentryUser ($result)
  {
    // Create the user
    $sentryUser = Sentry::createUser(
        array(
            'email' => $result['email'],
            'password' => time() . rand(999, 9999),
            'activated' => true,
            'first_name' => $result['given_name'],
            'last_name' => $result['family_name']
        ));

    return $sentryUser;
  }

/*
|--------------------------------------------------------------------------
| Login User
|--------------------------------------------------------------------------
| This function will login a user based on the user id provided and set the session data accordingly.
|--------------------------------------------------------------------------
| @param unknown $userId
*/
	public function loginUser ($userId)
	{
		$thisUser = Sentry::findUserById($userId);
		Sentry::login($thisUser, true);
		Session::put('checkAuth', 'true');
		Session::put('authUser', $this->getFullUserDetails($userId));
	}

  /**
   * This function is accumulating the sentry user and also adding the details table details of a user.
   * This can be always called instead of Snetry user to get all user details.
   * @param unknown $userId
   * @return unknown
   */
  public function getFullUserDetails ($userId)
  {
    $thisUser = Sentry::findUserById($userId);
    $thisUser['details'] = DB::table('details')->where('user_id',
        $userId)->first();

    return $thisUser;
  }
}
