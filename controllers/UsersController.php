<?php namespace Vedette\controllers;

use Vedette\models\User as User;
use View, Input, Redirect, Config, Validator, Hash, Auth, Form;
use Bootstrap;
use Datatable;

class UsersController extends BaseController {

	protected $user;

	public function __construct(User $user)
	{
		parent::__construct();
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

			if ( empty($input['roles']) ) $input['roles'] = array();
			$user->roles()->sync($input['roles']);

			$user->password = Hash::make($input['password']);

			$user->save();
			return Redirect::route('users.index')
				->withMessage(Bootstrap::success( trans('lingos::account.success.create'), true, true));
		}

		return Redirect::route('users.create')
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

		if ( !Auth::User()->hasRoleWithName('Admin') ) {
			return Redirect::to('/')
				->withMessage(Bootstrap::danger( trans('lingos::general.error.forbidden'), true, true));
		}

		$input = array_except(Input::all(), '_method');

		$validation = Validator::make($input, User::$rulesUpdate);

/*
		if( $validation->passes() ) {
			$user = Sentry::getUserProvider()->findById($id);
			$user->fill($validation->getData());
//dd($user);
			if (Input::has('activated')) {
				if ($user->isActivated()) {
				$user->activated = 1;
				$user->activated_at = $user->last_login;
				} else {
					$sentryUser = Sentry::getUserProvider()->findById($id);
					$activationCode = $sentryUser->getActivationCode();
//dd($activationCode);
					$user->attemptActivation($activationCode);
				}
			} else {
				$user->activated = 0;
				$user->activated_at = null;
			}

// update throttle
			$throttle = Sentry::getThrottleProvider()->findByUserId($id);

			if (Input::has('suspended')) {
// Suspend the user
				$throttle->suspend();
			} else {
// Suspend the user
				$throttle->unsuspend();
			}

// update ban
			if (Input::has('banned')) {
// Ban the user
				$throttle->ban();
			} else {
// Ban the user
				$throttle->unBan();
			}

			$user->save();
*/



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

			return Redirect::route('users.index')
				->withMessage(Bootstrap::success( trans('lingos::account.success.update'), true, true));

		}

		return Redirect::route('users.edit', $id)
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

		return Redirect::route('users.index')->withMessage(Bootstrap::success( trans('lingos::account.success.delete'), true, true));
	}

	/**
	 * @return mixed
	 */
	public function getDatatable()
	{
//		$query = User::select('email', 'id', 'created_at')->remember(10)->get();

		return Datatable::collection(User::all())
//		return Datatable::collection($query)
			->showColumns('id')

			->addColumn('email',
				function($model) {
					return $model->present()->email();
				})

			->addColumn('roles',
				function($model) {
					return $model->present()->roles();
				})

			->addColumn('actions',
				function($model) {
/*
				$modal =
					'<div class="modal fade" id="delete-Record-'.$model->id.'">
						'.Form::open(array("route" => array("users.destroy", $model->id), "method" => "delete")).'
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">' . trans('lingos::general.close') . '</span></button>
										<h4 class="modal-title">' . trans('lingos::account.ask.delete') . '</h4>
									</div>
									<div class="modal-body">
										<p>' . trans('lingos::account.ask.delete') . '<b>'.$model->id.'</b></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">' . trans('lingos::button.no') . '</button>
										<button type="submit" class="btn btn-success" name="deleteRecord">' . trans('lingos::button.yes') . '</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						'.Form::close().'
					</div><!-- /.modal -->';
*/
				$modal =
					'<div class="modal fade" id="delete-Record-'.$model->id.'">
						'.Form::open(array("route" => array("users.destroy", $model->id), "method" => "delete")).'
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">' . trans('lingos::general.close') . '</span></button>
										<h4 class="modal-title">' . trans('lingos::account.ask.delete') . '</h4>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">' . trans('lingos::button.no') . '</button>
										<button type="submit" class="btn btn-success" name="deleteRecord">' . trans('lingos::button.yes') . '</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						'.Form::close().'
					</div><!-- /.modal -->';
				return
					'<a href="/users/' . $model->id . '" class="btn btn-primary form-group" title="' . trans('lingos::general.view') . '"><i class="fa fa-chevron-right fa-fw"></i>' . trans('lingos::button.view') . '</a>&nbsp;'
					. '<a href="/users/' . $model->id . '/edit" class="btn btn-success form-group" title="' . trans('lingos::account.command.edit') . '"><i class="fa fa-edit fa-fw"></i>' . trans('lingos::button.edit') . '</a>&nbsp;'
					. Form::button('<span class="glyphicon glyphicon-trash"></span> ' . trans('lingos::button.delete'), array('name'=>'deleteRecord', 'class' => 'btn btn-danger', 'type' => 'button',  'data-toggle' => 'modal', 'data-target' => '#delete-Record-'.$model->id))
					. $modal;
				})

			->searchColumns('email', 'roles')
			->orderColumns('id','email', 'created_at')
			->make();
	}

}
