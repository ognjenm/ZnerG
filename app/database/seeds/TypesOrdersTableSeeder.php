<?php

class TypesOrdersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('typesOrders')->truncate();

		$data = array(
			array('id' => 1, 'id_campaign' => '1', 'name' => 'Web Order', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_campaign' => '1', 'name' => 'Phone Order', 'description' => '', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('typesOrders')->insert($data);
	}

}

