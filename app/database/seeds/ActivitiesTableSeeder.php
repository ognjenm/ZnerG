<?php

class ActivitiesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('activities')->truncate();

		$data = array(
			array('id' => '1', 'id_organization' => 4, 'id_application' => null, 'id_subprocess' => null, 'id_typesActivity' => 1, 'name' => 'Sales activity', 'description' => 'Here the salesperson executes any expected task with the purpose of acquiring the account', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => '2', 'id_organization' => 4, 'id_application' => null, 'id_subprocess' => null, 'id_typesActivity' => 3, 'name' => 'Retention', 'description' => 'After selling the process for retention starts', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => '3', 'id_organization' => 4, 'id_application' => null, 'id_subprocess' => null, 'id_typesActivity' => 1, 'name' => 'End', 'description' => 'End of the process', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('activities')->insert($data);
	}

}
