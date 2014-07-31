<?php

class EventsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('events')->truncate();

		$data = array(
			array('id' => 1, 'id_campaign' => '1', 'name' => 'Visit', 'description' => 'Visit a business', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_campaign' => '1', 'name' => 'Phone call', 'description' => 'Make a phone call', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_campaign' => '1', 'name' => 'Send an email', 'description' => 'Send an email', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_campaign' => '1', 'name' => 'Send a text message', 'description' => 'Send a text message', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_campaign' => '1', 'name' => 'Thank you note', 'description' => 'Send a thank you note', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('events')->insert($data);
	}

}

