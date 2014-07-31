<?php

class GroupsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('groups')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'Administrator', 'id_organization' => 1, 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'Administrator', 'id_organization' => 2, 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'Corporate Leader Trainer', 'id_organization' => 4, 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'Future Leader', 'id_organization' => 4, 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'Asistent Manager', 'id_organization' => 4, 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'name' => 'Administrator', 'id_organization' => 3, 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'name' => 'Administrator', 'id_organization' => 4, 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'name' => 'Administrator', 'id_organization' => 5, 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime
			array('id' => 9, 'name' => 'Manager', 'id_organization' => 4, 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
		));

		// Uncomment the below to run the seeder
		DB::table('groups')->insert($data);
	}

}
