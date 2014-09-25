<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthsTable extends Migration
{

	public function __construct()
	{
		// Get the prefix
		$this->prefix = Config::get('vedette::prefix', '');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create($this->prefix.'oauths', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->index();
			$table->string('oauth_id');

			$table->string('oauth_email');
			$table->string('oauth_name', 100);
			$table->string('oauth_given_name', 100);
			$table->string('oauth_family_name', 100);

			$table->text('oauth_link');
			$table->text('oauth_picture');
			$table->string('oauth_gender', 10);

			$table->string('oauth_updated', 15);

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists($this->prefix.'oauths');
	}
}
