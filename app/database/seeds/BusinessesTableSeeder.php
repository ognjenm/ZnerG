<?php

class BusinessesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('businesses')->truncate();

		$data = array(
			array('id' => 1, 'id_database' => 1, 'name' => 'Avanti Insurance Agency', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_database' => 1, 'name' => 'Car Mex Inc.', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('businesses')->insert($data);
	}

}
