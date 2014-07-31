<?php

class ApplicationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('applications')->truncate();

		$data = array(
		);

		// // Uncomment the below to run the seeder
		DB::table('applications')->insert($data);
	}

}

