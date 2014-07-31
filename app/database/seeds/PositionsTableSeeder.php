<?php

class PositionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('positions')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'name' => 'CEO', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => '1', 'name' => 'Assistent Manager', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => '1', 'name' => 'Senior Corporate Trainer', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => '1', 'name' => 'Corporate Trainer', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => '1', 'name' => 'Future Leader', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => '1', 'name' => 'Assistent', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('positions')->insert($data);
	}

}

