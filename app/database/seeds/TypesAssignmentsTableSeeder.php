<?php

class TypesAssignmentsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesAssignments')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Same', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Supervisor', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'Employee selected', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 1, 'name' => 'All employees with same position', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => 1, 'name' => 'All employees in the same team', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesAssignments')->insert($data);
	}

}

