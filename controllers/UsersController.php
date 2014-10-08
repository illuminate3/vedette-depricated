<?php namespace Vedette\controllers;

use Vedette\models\User as User;
use View, Input, Redirect, Config, Validator, Hash;
use Bootstrap;

class UsersController extends \BaseController {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->user->all();

		return View::make(
			Config::get('vedette.vedette_views.users_index')
			)->with(compact("users"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make(
			Config::get('vedette.vedette_views.users_create')
			);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$validation = Validator::make($input, User::$rules);

		if ($validation->passes())
		{

			$user = new User;
			$user->email = $input['email'];
			$user->password = Hash::make($input['password']);

			$user->save();

			if ( empty($input['roles']) ) $input['roles'] = array();
			$user->roles()->sync($input['roles']);

			return Redirect::route('admin.users.index')
				->withMessage(Bootstrap::success( trans('lingos::account.success.create'), true, true));
		}

		return Redirect::route('admin.users.create')
			->withInput()
			->withErrors($validation)
			->withMessage(Bootstrap::danger( trans('lingos::account.error.create'), true, true));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
//		$user = $this->user->findOrFail($id);
		$user = $this->user->with('profile')->findOrFail($id);

		return View::make(
			Config::get('vedette.vedette_views.users_show')
			)->with(compact('user'));
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
		$user = $this->user->findOrFail($id);

		return View::make(
			Config::get('vedette.vedette_views.users_edit')
			)->with(compact('user'));
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
		$input = array_except(Input::all(), '_method');

		$validation = Validator::make($input, User::$rulesUpdate);

		if ($validation->passes())
		{

			$user = User::findOrFail($id);

			$user->email = $input['email'];
			if ( ! empty($input['password']) && $input['password'] == $input['password_confirmation'])
			{
				$user->password = Hash::make($input['password']);
			}
			$user->save();

			if (empty($input['roles'])) $input['roles'] = array();
			$user->roles()->sync($input['roles']);

			return Redirect::route('admin.users.index')
				->withMessage(Bootstrap::success( trans('lingos::account.success.update'), true, true));

		}

		return Redirect::route('admin.users.edit', $id)
			->withInput()
			->withErrors($validation)
			->withMessage(Bootstrap::danger( trans('lingos::role.error.update'), true, true));


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
//dd('stop!');
		$user = $this->user->findOrFail($id);

//dd($user);
		$user->delete();
		User::deleteUserProfile($user['user_id']);

		if ($id == Auth::user()->id)
		{
			Auth::logout();
		}

		return Redirect::route('admin.users.index')->withMessage(Bootstrap::success( trans('lingos::account.success.delete'), true, true));
	}

}
