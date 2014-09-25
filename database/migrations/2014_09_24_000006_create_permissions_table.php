<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePermissionsTable extends Migration
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
		Schema::create($this->prefix.'permissions', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('name', 100)->unique()->index();
			$table->string('description');

			$table->timestamps();
			$table->softDeletes();
		});
        $this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix.'permissions');
	}

	/**
	 * Create default Permissions
	 *
	 * @author Steve Montambeault
	 * @link   http://stevemo.ca
	 *
	 * @return void
	 */
	public function seed()
	{
		DB::table($this->prefix.'permissions')->insert(array(
			array(
				'name' => 'view'
			),
			array(
				'name' => 'edit'
			),
			array(
				'name' => 'create'
			),
			array(
				'name' => 'delete'
			)
		));
	}

}
