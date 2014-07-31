<?php

class InstancesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('instances')->truncate();

		$data = array(
		);

		// Uncomment the below to run the seeder
		DB::table('instances')->insert($data);
	}

}

