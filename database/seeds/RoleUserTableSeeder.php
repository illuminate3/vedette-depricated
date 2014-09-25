<?php

class RoleUserTableSeeder extends Seeder {

	/**
	 * Run the seeder.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('user_role')->delete();
		DB::table('users')->truncate();

		$seeds = array(
			array(
			'email'    => 'admin@admin.com',
			'password' => 'sentryadmin',
			'activated' => 1,
			'verified' => 1,
			),
			array(
			'email'    => 'user@user.com',
			'password' => 'sentryuser',
			'activated' => 1,
			'verified' => 1,
			),
		);

		// Uncomment the below to run the seeder
		DB::table('user_role')->insert($seeds);
	}
}
