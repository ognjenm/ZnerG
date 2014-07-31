<?php

class TypesStartsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesStarts')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Needs just one rule to be true', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Needs all rules to be executed', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'Needs all rules to be true', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesStarts')->insert($data);
	}

}

