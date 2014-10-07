<?php namespace Vedette\controllers;

use Vedette\models\Role as Role;
use View, Input, Redirect, Config, Validator;
use Bootstrap;

class RolesController extends \BaseController {

	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::all();
		return View::make(
			Config::get('vedette.vedette_views.roles_index')
			)->with(compact("roles"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make(
			Config::get('vedette.vedette_views.roles_create')
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

		$validation = Validator::make($input, Role::$rules);

		if ($validation->passes())
		{
			$this->role->create($input);
			return Redirect::route('admin.roles.index')
				->withMessage(Bootstrap::success( trans('lingos::role.success.create'), true));
		}

		return Redirect::route('admin.roles.create')
			->withInput()
			->withErrors($validation)
			->withMessage(Bootstrap::danger( trans('lingos::role.error.create'), true));
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
		$role = Role::findOrFail($id);

		return View::make(
			Config::get('vedette.vedette_views.roles_edit')
			)->with(compact('role'));
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

		$validation = Validator::make($input, Role::$rulesUpdate);

		if ($validation->passes())
		{
			$role = $this->role->findOrFail($id);

			$role->name = $input['name'];
			$role->description = $input['description'];
			if (empty($input['level'])) {
				$role->level = NULL;
			} else {
				$role->level = $input['level'];
			}
			$role->active = (Input::has('active') ? 1 : 0);

			$role->save($input);

			return Redirect::route('admin.roles.index')
				->withMessage(Bootstrap::success( trans('lingos::role.success.update'), true));

		}

		return Redirect::route('admin.roles.edit', $id)
			->withInput()
			->withErrors($validation)
			->withMessage(Bootstrap::danger( trans('lingos::role.error.update'), true));
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
dd('stop!');
		$role = Role::findOrFail($id);
		$role->delete();

		return Redirect::route('admin.roles.index')
			->withMessage(Bootstrap::success( trans('lingos::role.success.delete'), true));
	}

}
