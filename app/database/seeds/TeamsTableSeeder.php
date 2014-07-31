<?php

class TeamsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('teams')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'Poseidon', 'id_organization' => 4, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'Summit', 'id_organization' => 4, 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('teams')->insert($data);
	}

}
