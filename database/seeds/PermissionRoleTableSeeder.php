<?php

use Faker\Factory as Faker;

class PasswordReminderTableSeeder extends Seeder {

	/**
	 * Run the seeder.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('password_reminders')->delete();

		$count = 5;
		$faker = Faker::create('en_GB');
		$users = User::all()->toArray();

		for( $x = 0 ; $x < $count; $x++ )
		{
			DB::table('password_reminders')->insert(array(
				'email' => $faker->randomElement($users)['email'],
				'token' => md5(0)
			));
		}
	}
}