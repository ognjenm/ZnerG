<?php

class LocationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('locations')->truncate();

		$data = array(
		);

		// // Uncomment the below to run the seeder
		DB::table('locations')->insert($data);
	}

}

