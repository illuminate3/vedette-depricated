<?php namespace Vedette\controllers;

use Vedette\helpers\forms\exceptions\FormValidationException;

use Vedette\models\User as User;
use View;
use Input;
use Hash;
use Redirect;
use Auth;
use Bootstrap;
use Config;

class AuthController extends \BaseController {

/*
	public function __construct(Register $registerForm, UserUpdate $userUpdateForm)
	{
		$this->registerForm = $registerForm;
		$this->userUpdateForm = $userUpdateForm;

		$this->beforeFilter('currentUser', array('only' => 'show', 'edit', 'update', 'destroy'));
	}
*/

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make(
			Config::get('vedette.vedette_views.register')
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('email', 'password', 'password_confirmation');
		$this->registerForm->validate($input);

		$user = new User;
		$user->email = $input['email'];
		$user->password = Hash::make($input['password']);
		$user->save();

		return Redirect::route('login')->withMessage(Bootstrap::success( trans('lingos::auth.success.account'), true));
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
		$user = Auth::user();

		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);

		return View::make('users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$input = Input::only('email', 'password', 'password_confirmation');
		$this->userUpdateForm->validate($input);

		$user->email = $input['email'];

		if ( ! empty($input['password']) && $input['password'] == $input['password_confirmation'])
		{
			$user->password = Hash::make($input['password']);
		}

		$user->save();

		return Redirect::route('user.show', $user->id)
			->withMessage(Bootstrap::success( trans('lingos::account.success.create'), true));
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

		Auth::logout();

		return Redirect::home()->withMessage(Bootstrap::success( trans('lingos::account.success.delete'), true));
	}

}
