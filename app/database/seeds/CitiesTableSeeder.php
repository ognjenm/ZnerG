<?php

class CitiesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('cities')->truncate();

		$data = array(
			array('id_state' => '43', 'name' => 'Dallas', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Fort Worth', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Irving', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Plano', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Carrolton', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Frisco', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Coppel', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Garland', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Haltom City', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Allen', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_state' => '43', 'name' => 'Arlington', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('cities')->insert($data);
	}

}

