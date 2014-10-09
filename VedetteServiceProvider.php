<?php namespace Vedette;

use Illuminate\Support\ServiceProvider;
use View;

class VedetteServiceProvider extends ServiceProvider {

	public function boot()
	{
		require_once(__DIR__.'/routes.php');
		require_once(__DIR__.'/filters.php');

		View::addLocation(app('path').'/Vedette/views');
		View::addNamespace('Vedette', app('path').'/Vedette/views/');
	}

	/**
	 * Register the binding
	 */
	public function register()
	{

		$this->registerRepository();
		$this->registerPasswordService();
		$this->registerLoginThrottleService();
		$this->registerUserValidator();
		$this->registerConfide();
//		$this->registerCommands();

	}

	/**
	 * Register the repository that will handle all the database
	 * interaction.
	 */
	protected function registerRepository()
	{
		$this->app->bind('confide.repository', function ($app) {
			return new EloquentRepository($app);
		});
	}

	/**
	 * Register the service that abstracts all user password management
	 * related methods
	 */
	protected function registerPasswordService()
	{
		$this->app->bind('confide.password', function ($app) {
			return new EloquentPasswordService($app);
		});
	}

	/**
	 * Register the service that Throttles login after
	 * too many failed attempts. This is a secure measure in
	 * order to avoid brute force attacks.
	 */
	protected function registerLoginThrottleService()
	{
		$this->app->bind('confide.throttle', function ($app) {
			return new CacheLoginThrottleService($app);
		});
	}

	/**
	 * Register the UserValidator class. The default class that
	 * used for user validation
	 */
	protected function registerUserValidator()
	{
		$this->app->bind('confide.user_validator', function ($app) {
			return new UserValidator();
		});
	}

	/**
	 * Register the application bindings.
	 */
	protected function registerConfide()
	{
		$this->app->bind('confide', function ($app) {
			return new Confide(
				$app->make('confide.repository'),
				$app->make('confide.password'),
				$app->make('confide.throttle'),
				$app
			);
		});
	}


}
