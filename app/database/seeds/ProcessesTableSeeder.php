<?php

class ProcessesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('processes')->truncate();

		$data = array(
			array('id' => '1', 'id_organization' => 4, 'id_campaign' => 1, 'id_initialActivity' => 1, 'id_metaData' => 1, 'id_typesProcess' => 1, 'name' => 'Customer acquisition', 'description' => '', 'isActive' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => '2', 'id_organization' => 4, 'id_campaign' => null, 'id_initialActivity' => null, 'id_metaData' => 2, 'id_typesProcess' => 1, 'name' => 'Prueba', 'description' => '', 'isActive' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('processes')->insert($data);
	}

}
