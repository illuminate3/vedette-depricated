<?php namespace Vedette\controllers;

use Auth, View, Session, App;

//
use Third\models\Pallet as Pallet;
use Third\models\Item as Item;
use Third\models\Rack as Rack;
use Third\models\Pick as Pick;
use Third\models\Alert as Alert;

//use BAM\models\Item as Item;
use BAM\models\Category as Category;

class IndexController extends \BaseController {

	public function __construct(Category $category, Item $item)
	{
		$this->category = $category;
		$this->item = $item;
	}

	/**
	 * Display an admin index view.
	 *
	 * @return Response
	 */
	public function index($slug = '/')
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
} elseif ( $_ENV['APP_TYPE'] == 'BAM' ) {
/*
$category = $this->category->with('items')->whereSlug($slug)->first();
//dd($category);
if ($category === null)
{
	App::abort(404, 'Sorry, but requested category doesn\'t exists.');
}
$this->layout->menu2 = $this->category->getMenu2($category);
*/

		return View::make('index');

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
