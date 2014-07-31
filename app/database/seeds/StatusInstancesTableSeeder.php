<?php

class StatusInstancesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('statusInstances')->truncate();

		$data = array(
			array('id' => 1, 'id_campaign' => 1, 'name' => 'Pending', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_campaign' => 1, 'name' => 'Executed', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_campaign' => 1, 'name' => 'Cancelled', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('statusInstances')->insert($data);
	}

}

