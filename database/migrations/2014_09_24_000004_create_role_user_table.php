<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
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
		Schema::create($this->prefix.'role_user', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->integer('role_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();

			$table->foreign('role_id')->references('id')->on($this->prefix.'roles')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on($this->prefix.'users')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix.'role_user');
	}

}
