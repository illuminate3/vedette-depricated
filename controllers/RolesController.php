<?php namespace Vedette\controllers;

use Vedette\helpers\forms\form\RoleCreate;
use Vedette\helpers\forms\form\RoleUpdate;
use Vedette\helpers\forms\exceptions\FormValidationException;

use Vedette\models\Role as Role;
use View;
use Input;
use Redirect;
use Bootstrap;
use Config;

class RolesController extends \BaseController {

	/**
	 * Roles create form validator
	 *
	 * @var Project\Forms\Form\RoleCreate
	 */
	protected $rolesCreateForm;

	/**
	 * Roles update form validator
	 *
	 * @var Project\Forms\Form\RoleUpdate
	 */
	protected $rolesUpdateForm;

	/**
	 * Construct the session controller with roles form validators
	 *
	 * @param RoleCreate $rolesCreateForm
	 * @param RoleUpdate $rolesUpdateForm
	 */
	public function __construct(RoleCreate $rolesCreateForm, RoleUpdate $rolesUpdateForm)
	{
		$this->rolesCreateForm = $rolesCreateForm;
		$this->rolesUpdateForm = $rolesUpdateForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::all();

//dd($roles);
//		return View::make('admin.roles.index')->with(compact("roles"));

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
//		return View::make('admin.roles.create');
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
		$input = Input::only('name', 'active', 'level');
		$this->rolesCreateForm->validate($input);

//dd($messages);
//dd($this->rolesCreateForm->validate($input));

		$role = new Role;

		$role->name = $input['name'];
		if (empty($input['level'])) {
			$role->level = NULL;
		} else {
			$role->level = $input['level'];
		}
		$role->active = (Input::has('active') ? 1 : 0);

//		$role->save();
//dd($role->save());
//		return Redirect::route('admin.roles.index')->withMessage(Bootstrap::success( trans('lingos::role.success.create'), true));

if ( ! $role->save())
{
	// Oops.
	return Redirect::route('admin.roles.create')
		->withErrors($post->getErrors())
		->withInput();
}

/*
return Redirect::route('posts.show', $post->id)
    ->withSuccess("Your post was saved successfully.");
*/
		return Redirect::route('admin.roles.index')->withMessage(Bootstrap::success( trans('lingos::role.success.create'), true));

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

//		return View::make('admin.roles.edit')->with(compact('role'));

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
		$input = Input::only('name', 'active', 'level');
		$this->rolesUpdateForm->validate($input);

		$role = Role::findOrFail($id);

		$role->name = $input['name'];
		if (empty($input['level'])) {
			$role->level = NULL;
		} else {
			$role->level = $input['level'];
		}
		$role->active = (Input::has('active') ? 1 : 0);

		$role->save();

		return Redirect::route('admin.roles.index')->withMessage(Bootstrap::success( trans('lingos::role.success.create'), true));
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

		return Redirect::route('admin.roles.index')->withMessage(Bootstrap::success( trans('lingos::role.success.delete'), true));
	}

}
