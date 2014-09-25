<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\UserCreate;
use Vedette\helpers\forms\form\UserUpdate;
use Vedette\helpers\forms\exceptions\FormValidationException;

use View;

class UsersController extends \BaseController {

	/**
	 * Users create form validator
	 *
	 * @var Project\Forms\Form\UserCreate
	 */
	protected $usersCreateForm;

	/**
	 * Users update form validator
	 *
	 * @var Project\Forms\Form\UserUpdate
	 */
	protected $usersUpdateForm;

	/**
	 * Construct the session controller with users form validators
	 *
	 * @param UserCreate $usersCreateForm
	 * @param UserUpdate $usersUpdateForm
	 */
	public function __construct(UserCreate $usersCreateForm, UserUpdate $usersUpdateForm)
	{
		$this->usersCreateForm = $usersCreateForm;
		$this->usersUpdateForm = $usersUpdateForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return View::make('admin.users.index')->with(compact("users"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('name', 'email', 'password', 'password_confirmation', 'roles');
		$this->usersCreateForm->validate($input);

		if (empty($input['roles'])) $input['roles'] = array();

		$user = new User;
		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->password = Hash::make($input['password']);
		$user->save();
		$user->roles()->sync($input['roles']);

		return Redirect::route('admin.index')->withMessage(Bootstrap::success('User created successfully.', true));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);

		return View::make('admin.users.edit')->with(compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('name', 'email', 'password', 'password_confirmation', 'roles');
		$this->usersUpdateForm->validate($input);

		if (empty($input['roles'])) $input['roles'] = array();

		$user = User::findOrFail($id);
		$user->name = $input['name'];
		$user->email = $input['email'];

		if ( ! empty($input['password']) && $input['password'] == $input['password_confirmation'])
		{
			$user->password = Hash::make($input['password']);
		}

		$user->save();
		$user->roles()->sync($input['roles']);

		return Redirect::route('admin.users.index')->withMessage(Bootstrap::success('User updated successfully.', true));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param integer $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();

		if ($id == Auth::user()->id)
		{
			Auth::logout();
		}

		return Redirect::route('admin.users.index')->withMessage(Bootstrap::success('User has been destroyed.', true));
	}

}
