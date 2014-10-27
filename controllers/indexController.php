<?php namespace Vedette\controllers;
use Auth;
use View;
use Session;

use Third\models\Pallet as Pallet;
use Third\models\Item as Item;
use Third\models\Rack as Rack;
use Third\models\Pick as Pick;
use Third\models\Alert as Alert;


class IndexController extends \BaseController {

	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index()
	{

if ( $_ENV['APP_TYPE'] == 'Third' ) {
		$pallet_count = count(Pallet::all());
		$item_count = count(Item::all());
//		$product_count = count(Item::all());
		$rack_count = count(Rack::all());
		$pick_count = count(Pick::all());

		$alerts = Alert::all();

		return View::make('index', compact(
				'pallet_count',
				'item_count',
//				'product_count',
				'rack_count',
				'pick_count',
				'alerts'
			));
} else {
		return View::make('index');
}

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
