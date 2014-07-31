<?php

class ColorsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('colors')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Red', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Green', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'Blue', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 1, 'name' => 'Yellow', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => 1, 'name' => 'Cyan', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => 1, 'name' => 'Magenta', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'id_organization' => 1, 'name' => 'Orange', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'id_organization' => 1, 'name' => 'White', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'id_organization' => 1, 'name' => 'Brown', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'id_organization' => 1, 'name' => 'Manila', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 11, 'id_organization' => 1, 'name' => 'Black', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('colors')->insert($data);
	}

}

