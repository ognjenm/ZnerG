<?php

class CurrenciesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('currencies')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'name' => 'American Dollars', 'symbol' => '$', 'created_at' => new DateTime),
			array('id' => 2, 'id_organization' => '1', 'name' => 'Canadian Dollars', 'symbol' => '$', 'created_at' => new DateTime),
			array('id' => 3, 'id_organization' => '1', 'name' => 'Peruvian Soles', 'symbol' => 'S/.', 'created_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('currencies')->insert($data);
	}

}

