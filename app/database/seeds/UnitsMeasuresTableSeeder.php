<?php

class UnitsMeasuresTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('unitsMeasures')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 1, 'name' => 'Box', 'symbol' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 1, 'name' => 'Carton', 'symbol' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 1, 'name' => 'Pack', 'symbol' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 1, 'name' => 'Dozen', 'symbol' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => 1, 'name' => 'Pounds', 'symbol' => 'lb', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => 1, 'name' => 'Ounces', 'symbol' => 'oz', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'id_organization' => 1, 'name' => 'Gallon', 'symbol' => 'gal', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('unitsMeasures')->insert($data);
	}

}

