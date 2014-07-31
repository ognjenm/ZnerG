<?php

class TypesCustomersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesCustomers')->truncate();

		$data = array(
			array('id' => 1, 'id_campaign' => '1', 'name' => 'Type 1', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_campaign' => '1', 'name' => 'Type 2', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));


	// 	// Uncomment the below to run the seeder
		DB::table('typesCustomers')->insert($data);
	}

}

