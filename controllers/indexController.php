<?php namespace Vedette\controllers;

use Auth;
use View;
use Session;

class IndexController extends \BaseController {

	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('index');
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
