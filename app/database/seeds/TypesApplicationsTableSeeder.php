<?php

class TypesApplicationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesApplications')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Custom', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'External', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'Procedure', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesApplications')->insert($data);
	}

}

