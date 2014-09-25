<?php namespace Vedette\controllers;

use View;

class AdminController extends \BaseController {

	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index()
	{
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
