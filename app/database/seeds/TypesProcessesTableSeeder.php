<?php

class TypesProcessesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesProcesses')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Open', 'description' => 'There is no limitation in time', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Closed', 'description' => 'There is limitation in time', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesProcesses')->insert($data);
	}

}

