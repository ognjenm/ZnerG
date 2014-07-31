<?php

class ActivitiesProcessesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('activitiesProcesses')->truncate();

		$data = array(
			array('id' => 1, 'id_process' => 1, 'id_activity' => 1, 'id_typesAssignment' => 1, 'id_typesNotification' => 1, 'name' => 'Sales task', 'hoursBefore' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_process' => 1, 'id_activity' => 2, 'id_typesAssignment' => 1, 'id_typesNotification' => 3, 'name' => 'Retention Subprocess', 'hoursBefore' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_process' => 1, 'id_activity' => 3, 'id_typesAssignment' => 1, 'id_typesNotification' => 1, 'name' => 'End', 'hoursBefore' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('activitiesProcesses')->insert($data);
	}

}

