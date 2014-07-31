<?php

class RulesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('rules')->truncate();

		$data = array(
		);

		// Uncomment the below to run the seeder
		DB::table('rules')->insert($data);
	}

}

