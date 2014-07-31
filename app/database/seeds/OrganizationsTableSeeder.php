<?php

class OrganizationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('organizations')->truncate();

		$data = array(
			array('id' => 1, 'id_parent' => null, 'shortName' => 'ZnerG', 'name' => 'ZnerG Inc.', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_parent' => null, 'shortName' => 'Cydcor', 'name' => 'Cydcor', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_parent' => '2', 'shortName' => 'DMC', 'name' => 'DMC Atlanta Inc.', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_parent' => '3', 'shortName' => 'Evantage', 'name' => 'Evantage Inc.', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_parent' => '4', 'shortName' => '7Marketing', 'name' => '7 Marketing', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('organizations')->insert($data);
	}

}
