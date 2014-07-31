<?php

class TypesFieldsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesFields')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Boolean', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Date', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'DateTime', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 1, 'name' => 'Decimal', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => 1, 'name' => 'Double', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => 1, 'name' => 'Float', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'id_organization' => 1, 'name' => 'Integer', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'id_organization' => 1, 'name' => 'String', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'id_organization' => 1, 'name' => 'Time', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesFields')->insert($data);
	}

}

