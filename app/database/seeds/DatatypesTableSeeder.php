<?php

class DatatypesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('datatypes')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'INT', 'position' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'VARCHAR', 'position' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'TEXT', 'position' => 15, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'DATE', 'position' => 5, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'TINYINT', 'position' => 8, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'name' => 'SMALLINT', 'position' => 9, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'name' => 'BIGINT', 'position' => 10, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'name' => 'DECIMAL', 'position' => 11, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'name' => 'FLOAT', 'position' => 12, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'name' => 'DOUBLE', 'position' => 13, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 11, 'name' => 'BOOLEAN', 'position' => 7, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 12, 'name' => 'DATETIME', 'position' => 6, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 13, 'name' => 'CHAR', 'position' => 3, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 14, 'name' => 'BLOB', 'position' => 16, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 15, 'name' => 'ENUM', 'position' => 4, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 16, 'name' => 'TIMESTAMP', 'position' => 14, 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('datatypes')->insert($data);
	}

}

