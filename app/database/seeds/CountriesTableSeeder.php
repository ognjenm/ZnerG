<?php

class CountriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('countries')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'name' => 'United States of America', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => '1', 'name' => 'Canada', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => '1', 'name' => 'Peru', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('countries')->insert($data);
	}

}

