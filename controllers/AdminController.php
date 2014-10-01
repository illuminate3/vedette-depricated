<?php namespace Vedette\controllers;

use Auth;
use View;
use Session;

class AdminController extends \BaseController {

	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index()
	{

//$data = Session::all();
//dd($data);

		return View::make('admin.index');
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

}
