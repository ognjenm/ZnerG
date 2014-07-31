<?php

class DatabasesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('databases')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'ZnerG', 'description' => 'Data belonging to ZnerG', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'Cydcor', 'description' => 'Cydcor\'s data', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('databases')->insert($data);
	}

}

