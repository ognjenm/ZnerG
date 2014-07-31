<?php

class CustomersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('customers')->truncate();

		$data = array(
		);

		// Uncomment the below to run the seeder
		DB::table('customers')->insert($data);
	}

}

