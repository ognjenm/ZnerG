<?php

class CategoriesParametersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//`DB::table('categoriesParameters')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'General', 'description' => '', 'order' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'Interface', 'description' => '', 'order' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'Performance', 'description' => '', 'order' => '3', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'WorkFlow', 'description' => '', 'order' => '4', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'Others', 'description' => '', 'order' => '5', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('categoriesParameters')->insert($data);
	}

}
