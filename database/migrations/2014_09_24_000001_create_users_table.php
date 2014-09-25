<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
		Schema::create($this->prefix.'users', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('email')->unique()->index();
			$table->string('password')->nullable()->index();

			$table->string('remember_token')->nullable()->index();
			$table->string('reset_password_code')->nullable();

			$table->boolean('verified')->default(0);
			$table->boolean('disabled')->default(0);

			$table->boolean('activated')->default(0);
			$table->timestamp('activated_at')->nullable();
			$table->string('activation_code')->nullable()->index();

			$table->timestamp('last_login')->nullable();


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
		Schema::drop($this->prefix.'users');
	}

}
