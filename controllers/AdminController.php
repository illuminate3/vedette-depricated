<?php namespace Vedette\controllers;

use Vedette\models\User as User;
use Auth;
use View;
use Session;

class AdminController extends BaseController {

	protected $user;

	public function __construct(User $user)
	{
		parent::__construct();
		$this->user = $user;
	}
/*
	public function __construct()
	{
		parent::__construct();
	}
*/
	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index()
	{
		$countUsers = $this->user->countUsers();

		return View::make('admin.index', compact(
			'countUsers'
		));

	}

	/**
	 * Display a not found view.
	 *
	 * @return Response
	 */
	public function notfound()
	{
		return View::make('errors.404');
	}


public function users() {
	$table = Datatable::table()
		->addColumn('email', 'last_login', 'view')
		->setUrl(route('api.profiles'))
		->noScript();

//	$this->layout->content = View::make('admin.users', array('table' => $table));
	$this->layout->content = View::make(
			'users.index',
			array(
				'table' => $table
			)
		);
}
public function getUsersDataTable(){

	$query = User::select('email', 'active', 'last_login', 'id')->get();

	return Datatable::collection($query)
		->addColumn('last_login', function($model){
		return date('M j, Y h:i A', strtotime($model->last_login));
		})
		->addColumn('id', function($model){
			return '<a href="/users/' . $model->id . '">view</a>';
		})
		->searchColumns('email', 'last_login')
		->orderColumns('email', 'last_login')
		->make();
}
}
