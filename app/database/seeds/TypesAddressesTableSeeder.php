<?php

class TypesAddressesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesAddresses')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Business', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Residential', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesAddresses')->insert($data);
	}

}

