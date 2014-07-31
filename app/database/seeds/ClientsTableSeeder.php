<?php

class ClientsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('clients')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 2, 'name' => 'Staples', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 2, 'name' => 'AT&T', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 2, 'name' => 'Verizon', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 2, 'name' => 'DirecTV', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('clients')->insert($data);
	}

}

