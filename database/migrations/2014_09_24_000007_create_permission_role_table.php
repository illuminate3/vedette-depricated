<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
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
		Schema::create('permission_role', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('permission_id')->unsigned()->index();
			$table->integer('role_id')->unsigned()->index();

			$table->foreign('permission_id')->references('id')->on($this->prefix.'permissions')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on($this->prefix.'roles')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix.'permission_role');
	}

}
