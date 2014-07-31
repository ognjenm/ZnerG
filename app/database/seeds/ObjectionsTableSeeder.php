<?php

class ObjectionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('objections')->truncate();

		$data = array(
		));

		// Uncomment the below to run the seeder
		DB::table('objections')->insert($data);
	}
}
