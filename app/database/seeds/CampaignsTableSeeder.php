<?php

class CampaignsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('campaigns')->truncate();

		$data = array(
			array('id' => 1, 'id_client' => '1', 'name' => 'Quill', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_client' => '2', 'name' => 'AT&T U-verse', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('campaigns')->insert($data);
	}

}

