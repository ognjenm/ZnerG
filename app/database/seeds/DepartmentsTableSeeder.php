<?php

class DepartmentsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('departments')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'name' => 'Management', 'description' => '', 'created_at' => new DateTime),
			array('id' => 2, 'id_organization' => '1', 'name' => 'Sales', 'description' => '', 'created_at' => new DateTime),
			array('id' => 3, 'id_organization' => '1', 'name' => 'Administration', 'description' => '', 'created_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('departments')->insert($data);
	}

}

