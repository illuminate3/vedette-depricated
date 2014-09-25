<?php namespace Vedette;

use Illuminate\Support\ServiceProvider;
use View;

class VedetteServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
	}

	public function boot()
	{
		require_once(__DIR__.'/routes.php');
		require_once(__DIR__.'/filters.php');

		View::addLocation(app('path').'/Vedette/views');
		View::addNamespace('Vedette', app('path').'/Vedette/views/');
	}

}
