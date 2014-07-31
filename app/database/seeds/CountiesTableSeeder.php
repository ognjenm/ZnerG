<?php

class CountiesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('counties')->truncate();

		$data = array(
			array('id_state' => '43', 'name' => 'Dallas', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Collin', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Denton', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Tarrant', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('counties')->insert($data);
	}

}

