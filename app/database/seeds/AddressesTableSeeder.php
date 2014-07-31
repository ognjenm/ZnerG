<?php

class AddressesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('addresses')->truncate();

		$data = array(
		);

		// // Uncomment the below to run the seeder
		DB::table('addresses')->insert($data);
	}

}

