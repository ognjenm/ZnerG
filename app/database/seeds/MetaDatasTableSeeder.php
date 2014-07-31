<?php

class MetaDatasTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('metaDatas')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '4', 'name' => 'Quill', 'description' => 'Office Supplies database', 'status' => 'Updated', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => '4', 'name' => 'Bo$$', 'description' => 'Beyond Office Supplies database', 'status' => 'Not Created', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('metaDatas')->insert($data);
	}

}
