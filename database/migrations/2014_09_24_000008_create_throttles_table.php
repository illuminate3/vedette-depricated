<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThrottlesTable extends Migration
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
	public function up()
	{
		Schema::create($this->prefix.'throttles', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->unsigned()->index();

			$table->boolean('banned')->default(0);
			$table->boolean('suspended')->default(0);
			$table->integer('attempts')->default(0);

			$table->timestamp('last_attempt_at')->nullable();
			$table->timestamp('suspended_at')->nullable();
			$table->timestamp('banned_at')->nullable();

			$table->string('ip_address')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix.'throttles');
	}

}
